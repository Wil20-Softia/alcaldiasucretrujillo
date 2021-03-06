??    U      ?  q   l      0  ?   1  ,   ,  5   Y  N   ?  7   ?  \   	  _   s	  `   ?	  u   4
  l   ?
  b     V   z  Y   ?  ~   +  ?   ?  %   :     `     w     ?     ?     ?     ?     ?       $   *     O     a     |     ?     ?  #   ?     ?     ?     ?          !     3     E  H   R     ?     ?     ?  !   ?          )  (   >     g     z  #   ?     ?     ?  $   ?          :  #   T  B   x  2   ?     ?           #     A  *   `  *   ?     ?     ?     ?  #   ?  #     &   <     c     r  ,   ?     ?     ?  -   ?          0     ?     N     d     z     ?     ?     ?  ?  ?  A  {  *   ?  7   ?  X      ?   y  \   ?  r     g   ?  p   ?  r   b  b   ?  ^   8  \   ?  u   ?  ?   j  *     !   :     \      {     ?     ?  %   ?     ?       '   $     L     j     ?     ?  *   ?  #   ?  #   ?     !     )     >     Y     t     ?  h   ?        "   )      L   .   l       ?   !   ?   I   ?   /   (!     X!  .   x!  "   ?!  ,   ?!  3   ?!  6   +"  *   b"  4   ?"  b   ?"  /   %#     U#      i#  $   ?#     ?#  /   ?#  1   ?#  %   0$     V$     g$  (   w$  (   ?$  /   ?$     ?$  $   %  6   9%     p%     ?%  7   ?%     ?%     ?%     &     &     ,&     J&     c&     &  /   ?&                .   5   0   6   ,   7         1   2   /   	          D      A       U      4              O               +   '   (   C      T          
       >   =      "   8          E           M   N          *      :   J   R            -   G                        P   K   Q   @           %   3   9   ?          $   I          ;   B   !          L          H           #           &   F      S   <             )          
If no -e, --expression, -f, or --file option is given, then the first
non-option argument is taken as the sed script to interpret.  All
remaining arguments are names of input files; if no input files are
specified, then the standard input is read.

       --help     display this help and exit
       --version  output version information and exit
   --follow-symlinks
                 follow symlinks when processing in place
   --posix
                 disable all GNU extensions.
   -R, --regexp-perl
                 use Perl 5's regular expressions syntax in the script.
   -b, --binary
                 open files in binary mode (CR+LFs are not processed specially)
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

 can't find label for jump to `%s' cannot remove %s: %s cannot rename %s: %s cannot specify modifiers on empty regexp cannot stat %s: %s command only uses one address comments don't accept any addresses couldn't attach to %s: %s couldn't edit %s: is a terminal couldn't edit %s: not a regular file couldn't follow symlink %s: %s couldn't open file %s: %s couldn't open temporary file %s: %s couldn't write %d item to %s: %s couldn't write %d items to %s: %s delimiter character is not a single-byte character error in subprocess expected \ after `a', `c' or `i' expected newer version of sed extra characters after command invalid reference \%d on `s' command's RHS invalid usage of +N or ~N as first address invalid usage of line address 0 missing command multiple `!'s multiple `g' options to `s' command multiple `p' options to `s' command multiple number options to `s' command no input files no previous regular expression number option to `s' command may not be zero option `e' not supported read error on %s: %s strings for `y' command are different lengths super-sed version %s
 unexpected `,' unexpected `}' unknown command: `%c' unknown option to `s' unmatched `{' unterminated `s' command unterminated `y' command unterminated address regex Project-Id-Version: sed 4.2.0
Report-Msgid-Bugs-To: bug-gnu-utils@gnu.org
POT-Creation-Date: 2009-06-27 15:08+0200
PO-Revision-Date: 2008-01-17 21:25+0100
Last-Translator: Helder Correia <helder.pereira.correia@gmail.com>
Language-Team: Portuguese <translation-team-pt@lists.sourceforge.net>
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=2; plural=n!=1;
 
Se não forem dadas as opções -e, --expression, -f ou --file, então, o primeiro
argumento não-opção é considerado como o 'script' a interpretar. Todos os
restantes argumentos só nomes de ficheiros de entrada; se não forem especificados
ficheiros de entrada, então, a entrada padrão (standard input) é lida.

       --help     exibir esta ajuda e sair
       --version  exibir informação de versão e sair
   --follow-symlinks
                 wguir ligações simbólicas ao processar no lugar
   --posix
                 desactivar todas as extensões GNU.
   -R, --regexp-perl
                 usar sintaxe expressões regulares Perl 5 no 'script'.
   -b, --binary
                 abrir ficheiros em modo binário (CR+LFs não são processados de forma especial)
   -e script, --expression=script
                 adicionar o 'script' aos comandos a serem executados
   -f script, --file=script
                 adicionar os conteúdos de 'script' aos comandos a serem executados
   -i[SUFIXO], --in-place[=SUFIXO]
                 editar ficheiros no lugar (salvaguarda se extensão fornecida)
   -l N, --line-length=N
                 especificar comprimento de linha desejado no comando 'l'
   -n, --quiet, --silent
                 elimir exibição automática do espaço de padrões
   -r, --regexp-extended
                 usar expressões regulares extendidas no 'script'.
   -s, --separate
                 considerar ficheiros como separados em vez de uma única longa corrente contínua.
   -u, --unbuffered
                 carregar quantidades mínimas de dados dos ficheiros de entrada e despejar mais frequentemente a memória temporária de saída
 %s: -e expressão #%lu, carácter %lu: %s
 %s: não é possível ler %s: %s
 %s: ficheiro %s linha %lu: %s
 : não quer quaisquer endereços GNU sed versão %s
 Referência de recuo inválida Nome de classe de carácter inválido Caráter inválido Conteúdo de \{\} inválido Expressão regular precedente inválida Limite de intervalo inválido Expressão regular inválida Memória esgotada Sem correspondência Expressão regular anterior não existente Fim prematuro de expressão regular Expressão regular demasiado grande Sucesso 'Backslash' no final ( ou \( não correspondido ) ou \) não correspondido [ ou [^ não correspondido \{ não correspondido Utilização: %s [OPÇÃO]... {'script'-apenas-se-não-houver-outro-'script'} [ficheiro-de-entrada]...

 comando 'e' não suportado '}' não quer quaisquer endereços baseado no GNU sed versão %s

 etiqueta para saltar para '%s' não encontrada não é possível remover %s: %s não é possível renomear %s: %s não é possível especificar modificadores numa expressão regular vazia não é possível obter informações de %s: %s comando usa apenas um endereço comentários não aceitam quaisquer endereços não foi possível anexar a %s: %s não foi possível editar %s: é um terminal não foi possível editar %s: ficheiro não regular não foi possível eguir a ligação simbólica %s: %s não foi possível abrir o ficheiro %s: %s não foi possível abrir ficheiro temporário %s: %s não foi possível escrever o %d item para %s: %s não foi possível escrever %d items para %s: %s carácter delimitador não tem um único 'byte' erro no subprocesso \ esperado após 'a', 'c' ou 'i' esperada versão mais recente do sed caracteres extra após comando referência \%d inválida no RHS do comando 's' uso inválido de +N ou ~N como primeiro endereço uso inválido do endereço de linha 0 comando em falta múltiplos "!"s múltiplas opções 'g' para comando 's' múltiplas opções 'p' para comando 's' múltiplas opções de número para comando 's' nenhum ficheiro de entrada não há expressão regular anterior opção de número para comando 's' pode não ser zero opção 'e' não suportada erro de leitura em %s: %s cadeias para o comando 'y' têm comprimentos diferentes super-sed versão %s
 ',' inesperada '{' inesperado comando desconhecido: '%c' opção desconhecida para 's' "{" sem correspondência comando 's' não concluído comando 'y' não concluído expressão regular de endereço não concluída 