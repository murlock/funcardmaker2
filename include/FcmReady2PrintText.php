<?php

require_once('include/FcmTextNugget.php');

/**
 * Afficheur de texte multiligne. Utilisé par des composants comme FcmMultiLineText
 */

class FcmReady2PrintText{
    
    /** Array des nuggets du texte à afficher. **/
    private $_nuggets;
    private $_font;
    private $_fontsize;
    private $_width, $_height;
    private $_charMetrics;  //line height is ['chararcterHeight']
    private $_imagick, $_imagickdraw;
    private $_cursor;
    
    public function getHeight() { return $this->_height; }
    
    /**
     * Constructeur.
     * @param $nuggets le texte à traiter, découpé en FcmTextLines
     * @param $font la police à utiliser
     * @param $fontsize la taille de police à utiliser en px.
     * @param $width la largeur de la boîte de texte en px.
     */
    public function __construct($nuggets, $font, $fontsize, $width) {
        $this->_nuggets = $nuggets;
        $this->_font = FcmMultiLineComponent::$fontManager->getFont($font);
        $this->_fontsize = $fontsize;
        $this->_width = $width;
        $this->_height = null;
        
        $this->_imagick = new Imagick();
        $this->_imagickdraw = new ImagickDraw();
        
        $this->_imagickdraw->setFont(realpath($this->_font));
        $this->_imagickdraw->setFontSize($this->_fontsize);
        $this->_charMetrics = $this->_imagick->queryFontMetrics($this->_imagickdraw, 'x');
    
        $this->_cursor = null;
        $this->_count = 0;
    }
    
    public function printText(){
        // TODO
    }
    
    /**
     * Effectue les tâches de pré-rendu : place les retours à ligne aux bons endroits
     * et calcule la hauteur totale du texte.
     */
    public function preRender(){
        $this->_cursor = new FcmTextCursor();
        //var_dump($this->_charMetrics);
        $this->_cursor->y = $this->_charMetrics['ascender'];
        
        $this->_count = count($this->_nuggets);
        for($i = 0 ; $i < $this->_count ; ++$i){
            $this->preRenderNugget($i);
        }
        
        $this->_cursor->y += $this->_charMetrics['descender'];
        
        $this->_height = $this->_cursor->y;
        
    }
    
    /**
     * Effectue le pré-rendu de la nugget numéro i (démarre à 0)
     */
    private function preRenderNugget($i){
        
        $coords = $this->_nuggets[$i]->getCursorUpdates($this->_imagick,
                                                        $this->_imagickdraw,
                                                        $this->_charMetrics,
                                                        $this->_cursor);
        
        // On vérifie si on doit aller à la ligne
        if($this->_cursor->x + $coords['x'] > $this->_width && $i > 0){
            // Ici, on doit insérer un retour à la ligne.
            // Si le nugget d'avant est un espace, on le transforme en NewLine
            if($this->_nuggets[$i-1] instanceof FcmTextNugget
              && preg_match('#\s+#', $this->_nuggets[$i-1]->getText())){
                $this->_nuggets[$i-1] = new FcmNewLineNugget();
            }
            // Sinon on en insère un à cette position.
            else{
                array_insert($this->_nuggets, $i, array(new FcmNewLineNugget()));
            }
            
            
            //var_dump($this->_nuggets);
            // On a inséré un retour à la ligne à cet endroit, avant le mot à computer.
            // On recalcule les coords pour l'avancement du curseur
            // TODO : Le nugget de texte sera donc computé deux fois. à améliorer.
            $coords = $this->_nuggets[$i]->getCursorUpdates($this->_imagick,
                                                        $this->_imagickdraw,
                                                        $this->_charMetrics,
                                                        $this->_cursor);
            
        }
        
        
        if($coords['y'] != 0){  // On effectue les retours chariots si necessaire
            $this->_cursor->y += $coords['y'];
            $this->_cursor->x = 0;
        } else {    // Sinon on avance sur l'axe horizontal
            $this->_cursor->x += $coords['x'];
        }
        
        
        
    }
    
    
    
}




/**
 * Curseur utilisé pour l'affichage et le calcul de géomtrie de texte
 */

class FcmTextCursor{
    
    public $x = 0, $y = 0;
    public $lineHeight = 1., $newParagraphHeight = 2., $newSectionHeight = 3.; // TODO revoir l'espacement des lignes et des paragraphes
    
}

