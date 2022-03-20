<?php

	require "fpdf/fpdf.php";
	require "functions.php";

	class Manual extends FPDF
	{
		public $outlines = array();
    	protected $outlineRoot;

		public function __construct(){
			parent::__construct('P','mm',array(215.9,279.4));
			$this->AddFont("Abril Fatface","","AbrilFatface-Regular.php");
			$this->AddFont("RobotoCondensed","","RobotoCondensed-Regular.php");
			$this->AddFont("RobotoCondensed","B","RobotoCondensed-Bold.php");
			$this->AddFont("Ubuntu","","Ubuntu-Regular.php");
			//SetMargins(izquierdo,arriba,derecho);
			$this->SetMargins(20,30,20);
			$this->AliasNbPages('{nb}');
			//SetAutoPageBreak(Salto de Pagina, Margen Inferior);
			$this->SetAutoPageBreak(true, 20);
		}

		/************************************************************
	    *                                                           *
	    *    MultiCell with bullet (array)                          *
	    *                                                           *
	    *    Requires an array with the following  keys:            *
	    *                                                           *
	    *        Bullet -> String or Number                         *
	    *        Margin -> Number, space between bullet and text    *
	    *        Indent -> Number, width from current x position    *
	    *        Spacer -> Number, calls Cell(x), spacer=x          *
	    *        Text -> Array, items to be bulleted                *
	    *                                                           *
	    ************************************************************/

    	function MultiCellBltArray($w, $h, $blt_array, $border=0, $align='J', $fill=false){
	        if (!is_array($blt_array))
	        {
	            die('MultiCellBltArray requires an array with the following keys: bullet,margin,text,indent,spacer');
	            exit;
	        }
	                
	        //Save x
	        $bak_x = $this->x;
	        
	        for ($i=0; $i<sizeof($blt_array['text']); $i++)
	        {
	            //Get bullet width including margin
	            $blt_width = $this->GetStringWidth($blt_array['bullet'] . $blt_array['margin'])+$this->cMargin*2;
	            
	            // SetX
	            $this->SetX($bak_x);
	            
	            //Output indent
	            if ($blt_array['indent'] > 0)
	                $this->Cell($blt_array['indent']);
	            
	            //Output bullet
	            $this->Cell($blt_width,$h,$blt_array['bullet'] . $blt_array['margin'],0,'',$fill);
	            
	            //Output text
	            $this->MultiCell($w-$blt_width,$h,$blt_array['text'][$i],$border,$align,$fill);
	            
	            //Insert a spacer between items if not the last item
	            if ($i != sizeof($blt_array['text'])-1)
	                $this->Ln($blt_array['spacer']);
	            
	            //Increment bullet if it's a number
	            if (is_numeric($blt_array['bullet']))
	                $blt_array['bullet']++;
	        }
	    
	        //Restore x
	        $this->x = $bak_x;
	    }

	    /****************************************************************
	    		SECCION DEL MARCADO DE INDICE POR CONTENIDO
	    ****************************************************************/
	    function Bookmark($txt, $isUTF8=false, $level=0, $y=0)
	    {
	        if(!$isUTF8)
	            $txt = utf8_encode($txt);
	        if($y==-1)
	            $y = $this->GetY();
	        $this->outlines[] = array('t'=>$txt, 'l'=>$level, 'y'=>($this->h-$y)*$this->k, 'p'=>$this->PageNo());
	    }

	    function _putbookmarks()
	    {
	        $nb = count($this->outlines);
	        if($nb==0)
	            return;
	        $lru = array();
	        $level = 0;
	        foreach($this->outlines as $i=>$o)
	        {
	            if($o['l']>0)
	            {
	                $parent = $lru[$o['l']-1];
	                // Set parent and last pointers
	                $this->outlines[$i]['parent'] = $parent;
	                $this->outlines[$parent]['last'] = $i;
	                if($o['l']>$level)
	                {
	                    // Level increasing: set first pointer
	                    $this->outlines[$parent]['first'] = $i;
	                }
	            }
	            else
	                $this->outlines[$i]['parent'] = $nb;
	            if($o['l']<=$level && $i>0)
	            {
	                // Set prev and next pointers
	                $prev = $lru[$o['l']];
	                $this->outlines[$prev]['next'] = $i;
	                $this->outlines[$i]['prev'] = $prev;
	            }
	            $lru[$o['l']] = $i;
	            $level = $o['l'];
	        }
	        // Outline items
	        $n = $this->n+1;
	        foreach($this->outlines as $i=>$o)
	        {
	            $this->_newobj();
	            $this->_put('<</Title '.$this->_textstring($o['t']));
	            $this->_put('/Parent '.($n+$o['parent']).' 0 R');
	            if(isset($o['prev']))
	                $this->_put('/Prev '.($n+$o['prev']).' 0 R');
	            if(isset($o['next']))
	                $this->_put('/Next '.($n+$o['next']).' 0 R');
	            if(isset($o['first']))
	                $this->_put('/First '.($n+$o['first']).' 0 R');
	            if(isset($o['last']))
	                $this->_put('/Last '.($n+$o['last']).' 0 R');
	            $this->_put(sprintf('/Dest [%d 0 R /XYZ 0 %.2F null]',$this->PageInfo[$o['p']]['n'],$o['y']));
	            $this->_put('/Count 0>>');
	            $this->_put('endobj');
	        }
	        // Outline root
	        $this->_newobj();
	        $this->outlineRoot = $this->n;
	        $this->_put('<</Type /Outlines /First '.$n.' 0 R');
	        $this->_put('/Last '.($n+$lru[0]).' 0 R>>');
	        $this->_put('endobj');
	    }

	    function _putresources()
	    {
	        parent::_putresources();
	        $this->_putbookmarks();
	    }

	    function _putcatalog()
	    {
	        parent::_putcatalog();
	        if(count($this->outlines)>0)
	        {
	            $this->_put('/Outlines '.$this->outlineRoot.' 0 R');
	            $this->_put('/PageMode /UseOutlines');
	        }
	    }

	    public function Footer()
		{
			$this->SetXY(190,-15);
			$this->SetTextColor(124,131,126);
			$this->SetFont("Arial", "BI", 8);
			$this->Cell(0, 10, "Pag. " . $this->PageNo() . " de {nb}", 0, 0, "C");
		}
	}
?>