??    O      ?  k         ?  ?   ?  ,   ?  5   ?  7     \   O  `   ?  u   	  l   ?	  b   ?	  V   S
  Y   ?
  ~     ?   ?  %        9     P     j     ?     ?     ?     ?     ?  $        (     :     U     f     o  #   ?     ?     ?     ?     ?     ?            H   +     t     ?     ?  !   ?     ?       (        @  #   ^     ?  $   ?     ?  #   ?  B     2   H     {      ?     ?     ?  *   ?  *        C     c     s  #   ?  #   ?  &   ?     ?  ,        <     U  -   j     ?     ?     ?     ?     ?     ?               8  }  S  &  ?  /   ?  L   (  A   u     ?  c   7  ?   ?  ?   -     ?  a   F  ?   ?  ?   +  ?   ?  +   q     ?     ?     ?     ?       $   '     L     l  .   ?     ?     ?     ?     ?  %     )   5      _     ?     ?     ?     ?     ?     ?  \   ?  #   G     k     ?  4   ?     ?     ?  J     $   g  +   ?  '   ?  8   ?  %      0   ?   J   p   >   ?      ?      !  ,   8!  %   e!  <   ?!  7   ?!  ,    "     -"     @"  '   N"  '   v"  .   ?"  %   ?"  7   ?"      +#     L#  E   i#     ?#     ?#     ?#     ?#     ?#     $     $$     ;$  (   R$                  A   '                      3      
                    6   L   	   5           7   N   H   +   <            0   4      9      @                %   O            &   1       ;   .                                *   (       #       $      ,   =       2   C   K          D      /   8                      E       )   B   >   M   J      -      :       F   !   I       "       ?   G        
If no -e, --expression, -f, or --file option is given, then the first
non-option argument is taken as the sed script to interpret.  All
remaining arguments are names of input files; if no input files are
specified, then the standard input is read.

       --help     display this help and exit
       --version  output version information and exit
   --posix
                 disable all GNU extensions.
   -R, --regexp-perl
                 use Perl 5's regular expressions syntax in the script.
   -e script, --expression=script
                 add the script to the commands to be executed
   -f script-file, --file=script-file
                 add the contents of script-file to the commands to be executed
   -i[SUFFIX], --in-place[=SUFFIX]
                 edit files in place (makes backup if extension supplied)
   -l N, --line-length=N
                 specify the desired line-wrap length for the `l' command
   -n, --quiet, --silent
                 suppress automatic printing of pattern space
   -r, --regexp-extended
                 use extended regular expressions in the script.
   -s, --separate
                 consider files as separate rather than as a single continuous
                 long stream.
   -u, --unbuffered
                 load minimal amounts of data from the input files and flush
                 the output buffers more often
 %s: -e expression #%lu, char %lu: %s
 %s: can't read %s: %s
 %s: file %s line %lu: %s
 : doesn't want any addresses GNU sed version %s
 Invalid back reference Invalid character class name Invalid collation character Invalid content of \{\} Invalid preceding regular expression Invalid range end Invalid regular expression Memory exhausted No match No previous regular expression Premature end of regular expression Regular expression too big Success Trailing backslash Unmatched ( or \( Unmatched ) or \) Unmatched [ or [^ Unmatched \{ Usage: %s [OPTION]... {script-only-if-no-other-script} [input-file]...

 `e' command not supported `}' doesn't want any addresses based on GNU sed version %s

 can't find label for jump to `%s' cannot remove %s: %s cannot rename %s: %s cannot specify modifiers on empty regexp command only uses one address comments don't accept any addresses couldn't edit %s: is a terminal couldn't edit %s: not a regular file couldn't open file %s: %s couldn't open temporary file %s: %s couldn't write %d item to %s: %s couldn't write %d items to %s: %s delimiter character is not a single-byte character error in subprocess expected \ after `a', `c' or `i' expected newer version of sed extra characters after command invalid reference \%d on `s' command's RHS invalid usage of +N or ~N as first address invalid usage of line address 0 missing command multiple `!'s multiple `g' options to `s' command multiple `p' options to `s' command multiple number options to `s' command no previous regular expression number option to `s' command may not be zero option `e' not supported read error on %s: %s strings for `y' command are different lengths super-sed version %s
 unexpected `,' unexpected `}' unknown command: `%c' unknown option to `s' unmatched `{' unterminated `s' command unterminated `y' command unterminated address regex Project-Id-Version: sed 4.1.4
Report-Msgid-Bugs-To: bug-gnu-utils@gnu.org
POT-Creation-Date: 2009-06-27 15:08+0200
PO-Revision-Date: 2005-04-23 16:29+0200
Last-Translator: Ga?l Qu?ri <gael@lautre.net>
Language-Team: French <traduc@traduc.org>
MIME-Version: 1.0
Content-Type: text/plain; charset=ISO-8859-1
Content-Transfer-Encoding: 8-bit
Plural-Forms: nplurals=2; plural=(n > 1);
 
Si aucune option -e, --expression, -f ou --file n'est donn?e, le
premier argument qui n'est pas une option sera pris comme ?tant le script
sed ? interpr?ter. Tous les arguments restants sont les noms des fichiers
d'entr?e; si aucun fichier d'entr?e n'est sp?cifi?e, l'entr?e standard
est lue.
       --help     afficher cette aide et sortir
       --version  afficher les informations de version du logiciel et sortir
   --posix
                 d?sactiver toutes les extensions GNU.
   -R, --regexp-perl
                 utiliser la syntaxe des expressions r?guli?res
                 de Perl 5 dans le script.
   -e script, --expression=script
                 ajouter le script aux commandes ? ?tre ex?cut?es
   -f fichier-script, --file=fichier-script
                 ajouter le contenu de fichier-script aux commandes
                 ? ?tre ex?cut?es
   -i[SUFFIXE], --in-place[=SUFFIXE]
                 ?diter les fichiers ? leur place (fait une
                 sauvegarde si l'extension est fournie)
   -l N, --line-length=N
                sp?cifier la longueur de coupure de ligne d?sir?e pour la
                commande `l'
   -n, --quiet, --silent
                 supprimer l'?criture automatique de l'espace des motifs
   -r, --regexp-extended
                 utiliser la syntaxe des expressions r?guli?res
                 ?tendues dans le script.
   -s, --separate
                consid?rer les fichiers comme s?par?s plut?t que comme un
                simple flux long et continu.
   -u, --unbuffered
                 charger des quantit?s minimales de donn?es depuis les
                 fichiers d'entr?e et lib?rer les tampons de sortie plus
                 souvent
 %s: -e expression n?%lu, caract?re %lu: %s
 %s: impossible de lire %s: %s
 %s: fichier %s ligne %lu: %s
 : n'a besoin d'aucune adresse GNU sed version %s
 R?f?rence arri?re invalide Nom de classe de caract?res invalide Caract?re de collation invalide Contenu de \{\} invalide L'expression r?guli?re pr?c?dente est invalide Fin d'intervalle invalide Expression r?guli?re invalide M?moire ?puis?e Pas de concordance Pas d'expression r?guli?re pr?c?dente Fin pr?matur?e d'une expression r?guli?re Expression r?guli?re trop grande Succ?s Antislash de protection ( ou \( non referm? ) ou \) non referm? [ ou [^ non referm? \{ non referm? Utilisation: %s [OPTION]... {script-seulement-si-pas-d'autre-script}
[fichier-d'entr?e]...

 la commande `e' n'est pas support?e `}' n'a besoin d'aucune adresse fond? sur GNU sed version %s

 impossible de trouver l'?tiquette pour sauter ? `%s' impossible de supprimer %s: %s impossible de renommer %s: %s impossible de sp?cifier des modifieurs sur une expression
rationnelle vide la commande n'utilise qu'une adresse les commentaires n'acceptent aucune adresse impossible d'?diter %s: est un terminal impossible d'?diter %s: ce n'est pas un fichier r?gulier impossible d'ouvrir le fichier %s: %s impossible d'ouvrir le fichier temporaire %s: %s impossible d'?crire %d item ? %s: %s impossible d'?crire %d items ? %s: %s le caract?re d?limiteur n'est pas un caract?re ? un seul octet erreur dans le sous-processus \ attendu apr?s `a', `c' ou `i' une version plus r?cente de sed est attendue caract?res inutiles apr?s la commande r?f?rence \%d invalide dans le c?t? droit de la commande `s' utilisation invalide de +N ou ~N comme premi?re adresse utilisation invalide de l'adresse de ligne 0 commande manquante `!' multiples plusieurs options `g' ? la commande `s' plusieurs options `p' ? la commande `s' plusieurs options num?riques ? la commande `s' pas d'expression r?guli?re pr?c?dente l'option num?rique de la comande `s' ne peut ?tre nulle l'option `e' n'est pas support?e erreur de lecture sur %s: %s les cha?nes destin?es ? la commande `y' ont des longueurs diff?rentes super-sed version %s
 `,' inattendue `}' inattendu commande inconnue: `%c' option inconnue pour `s' `{' non referm?e commande `s' inachev?e commande `y' inachev?e expression r?guli?re d'adresse inachev?e 