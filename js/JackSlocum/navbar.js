
YAHOO.ext.NavBar = function(minbarContainer, dockbarContainer, dockedWidth, margin, docked){
    this.dockedWidth = dockedWidth || 200;
    this.docked = docked || false;
    this.expanded = false;
    this.margin = (typeof margin == 'undefined' || margin == null) ? 4 : margin;
    
    this.minbar = new YAHOO.ext.Actor(minbarContainer);
    this.dockbar = new YAHOO.ext.Actor(dockbarContainer);
    
    this.beforeDock = new YAHOO.util.CustomEvent('NavBar.beforeDock');
    this.beforeBar = new YAHOO.util.CustomEvent('NavBar.beforeBar');
    this.onDock = new YAHOO.util.CustomEvent('NavBar.onDock');
    this.onBar = new YAHOO.util.CustomEvent('NavBar.onBar');
    this.onSlideOut = new YAHOO.util.CustomEvent('NavBar.onSlideOut');
    this.onSlideIn = new YAHOO.util.CustomEvent('NavBar.onSlideIn');
    
    this.dockDelegate = this.dock.createDelegate(this);
    this.undockDelegate = this.undock.createDelegate(this);
    this.slideInDelegate = this.slideIn.createDelegate(this);
    this.slideOutDelegate = this.slideOut.createDelegate(this);
    
    this.fireDocked = this.onDock.fire.createDelegate(this.onDock);
    this.fireBar = this.onBar.fire.createDelegate(this.onBar);
    this.fireSlideOut = this.onSlideOut.fire.createDelegate(this.onSlideOut);
    this.fireSlideIn = this.onSlideIn.fire.createDelegate(this.onSlideIn);
    if(this.docked){
        this.quickDock();
    }
};

YAHOO.ext.NavBar.prototype = {
    dock : function(e, oncomplete){
        if(e){YAHOO.util.Event.preventDefault(e);}
        
        if(this.expanded){
            if(e){YAHOO.util.Event.stopEvent(e);}
            this.slideOut(null, this.dockDelegate.createCallback(null, oncomplete));
            return;
        }
        
        this.beforeDock.fire();
        this.docked = true;
        
        var anim = new YAHOO.ext.Animator(this.minbar, this.dockbar);
        anim.startCapture();
        this.dockbar.setX(-this.dockedWidth);
        this.dockbar.setWidth(this.dockedWidth);
        this.dockbar.setVisible(true);
        
        anim.beginSync();
        this.minbar.move('left', this.minbar.getWidth()+this.margin, true, .35);
        this.dockbar.move('right', this.dockedWidth+this.margin, true, .4, null, YAHOO.util.Easing.easeOut);
        anim.endSync();
        
        this.dockbar.setLeft(this.margin + 'px');
        
        anim.stopCapture();
        anim.play(this.fireDocked.createSequence(oncomplete));
    },

    quickDock : function(){
        this.beforeDock.fire();
        this.docked = true;
        this.dockbar.setLeft(this.margin+'px');
        this.dockbar.setWidth(this.dockedWidth);
        this.dockbar.setVisible(true);
        this.minbar.setVisible(false);
        this.fireDocked();
    },

    undock : function(e, oncomplete){
        if(e){YAHOO.util.Event.preventDefault(e);}
        if(!this.docked){
            if(oncomplete){oncomplete()};
            return;
        }
        this.beforeBar.fire();
        this.docked = false;
        
        var anim = new YAHOO.ext.Animator(this.minbar, this.dockbar);
        anim.startCapture();
        this.minbar.setVisible(true);
        this.minbar.setX(-this.minbar.getWidth());
        
        anim.beginSync();
        this.dockbar.move('left', this.dockedWidth+this.margin, true, .25, null, YAHOO.util.Easing.easeIn);
        this.minbar.move('right', this.minbar.getWidth()+this.margin, true, .3);
        anim.endSync();
        
        this.minbar.setLeft(this.margin + 'px');
        
        anim.stopCapture();
        anim.play(this.fireBar.createSequence(oncomplete));
        
    },

    quickUndock : function(){
        this.beforeBar.fire();
        this.docked = false;
        this.dockbar.setVisible(false);
        this.minbar.setVisible(true);
        this.minbar.setLeft(this.margin + 'px');
        this.onBar.fire();        
    },

    slideIn : function(e, oncomplete){
        if(e){YAHOO.util.Event.preventDefault(e);}
        if(this.expanded){
            if(oncomplete){oncomplete();};
            return; // dont stop the event, just prevent the default
        }
        if(e){YAHOO.util.Event.stopEvent(e);} 
        // when they click anywhere, hide the nav
        YAHOO.util.Event.addListener(document.body, 'click', this.slideOutDelegate);
        this.expanded = true;
        this.dockbar.startCapture(true);
        this.dockbar.alignTo(this.minbar, 'tr'); 
        this.dockbar.blindShow('left', this.dockedWidth, .35);
        this.dockbar.play(this.fireSlideOut.createSequence(oncomplete));
    },

    slideOut : function(e, oncomplete){
        if(this.expanded){
            this.expanded = false;
            this.dockbar.startCapture(true);
            this.dockbar.blindHide('left', .35);
            this.dockbar.setVisible(false);
            this.dockbar.play(this.fireSlideIn.createSequence(oncomplete));
            YAHOO.util.Event.removeListener(document.body, 'click', this.slideOutDelegate);
        }else{
            if(oncomplete){oncomplete();};
        }
    },
    
    isDocked : function(){
        return this.docked;
    }
};
