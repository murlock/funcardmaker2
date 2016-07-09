// Dictionnaire des templates

var existingTemplates = [];     // contient tous mes templates de base

/**
 * Modern Basic
 */

function ModernBasicTemplate(){
    Funcard.call(this);
    
    this.template = 'modern-basic';
    
    this.panels = [
        existingPanels['modernbasicbackground'],
        existingPanels['illustration'],
        existingPanels['titre-type'],
        existingPanels['cm'],
        existingPanels['capa'],
        existingPanels['fe'],
        existingPanels['se'],
        existingPanels['illus-copy']
    ];
    
    this.resetSize();
    /*this.width = Math.floor(791./2.);
    this.height = Math.floor(1107./2.);*/
    this.illusWidth = 651;
    this.illusHeight = 480;
    
}
ModernBasicTemplate.prototype = Object.create(Funcard.prototype);

ModernBasicTemplate.prototype.resetSize = function(){
    this.width = 791;
    this.height = 1107;
}

existingTemplates['modern-basic'] = new ModernBasicTemplate();









/**
 * Old Basic
 */

function OldBasicTemplate(){
    Funcard.call(this);
    
    this.template = 'old-basic';
    
    this.panels = [
        existingPanels['modernbasicbackground'],
        existingPanels['illustration'],
        existingPanels['titre-type'],
        existingPanels['cm'],
        existingPanels['capa'],
        existingPanels['fe'],
        existingPanels['se'],
        existingPanels['illus-copy']
    ];
    
    this.resetSize();
    /*this.width = Math.floor(791./2.);
    this.height = Math.floor(1107./2.);*/
    this.illusWidth = 601;
    this.illusHeight = 485;
    
}
OldBasicTemplate.prototype = Object.create(Funcard.prototype);

OldBasicTemplate.prototype.resetSize = function(){
    this.width = 787;
    this.height = 1087;
}

existingTemplates['old-basic'] = new OldBasicTemplate();