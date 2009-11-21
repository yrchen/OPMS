
// global vars for legacy code
var Dom = YAHOO.util.Dom;
var Event = YAHOO.util.Event;

var Blog = {
    initUI : function(){
        this.innerBody = getEl('innerBody');
        this.sidebarInner = getEl('sidebar-inner');
        this.blogBody = getEl('blogBody');
        this.splitter = getEl('splitter');
        this.ncollapse = getEl('nav-collapse');
        this.views = getEl('page-views');
        this.commentBox = getEl('comments-box');
        
        this.handleResize();
        
        var splitCookie = parseInt(Cookies.get('hsplit'));
        var userWidth = isNaN(splitCookie) ? 200 : splitCookie;
        
        this.navbar = new YAHOO.ext.NavBar('navbar', 'sidebar', userWidth, 4);
        this.navbar.beforeBar.subscribe(this.adjustBody.createDelegate(this));
        var adjustUIDelegate = this.adjustUI.createDelegate(this);
        this.navbar.onDock.subscribe(adjustUIDelegate);
        this.navbar.onBar.subscribe(adjustUIDelegate);
        if(Cookies.get('navState') == 'docked'){
            this.navbar.quickDock();
        }else{
            this.navbar.quickUndock();
        }
        
        this.sidebarInner.setWidth(this.navbar.dockedWidth-2);
        
        var split = new YAHOO.ext.SplitBar('splitter', 'sidebar');
        split.setAdapter(new YAHOO.ext.SplitBar.AbsoluteLayoutAdapter('blogBody'));
        split.minSize = 150;
        split.maxSize = 400;
        split.animate = true;
        split.onMoved.subscribe(this.splitterMoved.createDelegate(this));
        
        YAHOO.util.Event.on('nav-dock', 'click', this.navbar.dockDelegate); 
        YAHOO.util.Event.on('nav-expand', 'click', this.navbar.slideInDelegate); 
        YAHOO.util.Event.on('nav-collapse', 'click', this.navbar.undockDelegate);
        
        if(this.views && this.views.dom){
           setTimeout(this.updateViews.createDelegate(this), 500);
        }
        
        if(this.commentBox && this.commentBox.dom){
           this.cmresizer = new YAHOO.ext.Resizable(this.commentBox, 
                    {minHeight:100, minWidth:100, resizeChild:true, adjustments:[0,-2]});
           this.updateResizer();
        }
        try{
            urchinTracker();
        }catch(e){}
    },
    
    updateViews : function(){
        this.views.getUpdateManager().update('/yui/log_view.php', 
                        {log: 'true', postId: this.views.dom.getAttribute('postId')});
    },
    
    getBodyDimensions : function(){
        return {
            width: YAHOO.util.Dom.getViewportWidth()-/*pad*/4,
            height: YAHOO.util.Dom.getViewportHeight() - (getEl('blog-header').getHeight()+8)
        };
    },
    
    pinCommentResize : function(){
        this.commentBox.toggleClass('yresizable-pinned');
        var pinned = this.commentBox.hasClass('yresizable-pinned');
        this.cmresizer.adjustments = pinned ? [-6,-7] : [0,-2];
        getEl('cmpinlink').update(pinned ? 'Float the resize handles' : 'Pin the resize handles');
        this.cmresizer.updateChildSize();
        
    },
    
    handleResize : function(){
        var size = this.getBodyDimensions();
        this.blogBody.setSize(size.width, size.height);
        YAHOO.util.Dom.setStyle(['navbar','splitter','sidebar'], 'height', size.height +'px');
        this.updateResizer();
    },
    
    updateResizer : function(){
        var cr = this.cmresizer;
        if(cr){
            cr.maxWidth = this.innerBody.getWidth()-20;
            if(cr.el.getWidth() > cr.maxWidth){
                cr.el.setWidth(cr.maxWidth);
            }
        }
    },
    
    splitterMoved : function(hsplitter, newSize){
        this.innerBody.setStyle('margin-left', newSize + /*pad+borders*/10);
        this.navbar.dockedWidth = newSize;
        this.sidebarInner.setWidth(newSize-2);
        Cookies.set('hsplit', newSize);
        this.updateResizer();
    },
    
    adjustUI : function(){
        if(this.navbar.isDocked()){
            this.innerBody.setStyle('margin-left', this.navbar.dockedWidth+10);
            this.ncollapse.setVisible(true);
            this.splitter.setVisible(true);
            this.splitter.setLeft(this.navbar.dockedWidth+4);
            Cookies.set('navState', 'docked');
        }else{
            this.splitter.setVisible(false);
            this.ncollapse.setVisible(false);
            Cookies.set('navState', 'undocked');
        }
    },
    
    adjustBody : function(){
        this.innerBody.setStyle('margin-left', this.navbar.minbar.getWidth()+10);
        this.updateResizer();
    }
};


// example code
function doExample1(){
    var el = getEl('example1');
    el.toggle(/*fade*/true);
}

function doExample2(){
    var el = getEl('example2');
    el.setBounds(0, el.getY(), 0, 0, true, .2, seeYaButton);
}
function seeYaButton(){
    var btn = getEl('button2');
    btn.enableDisplayMode();
    btn.setVisible(false, true);
}

function doExample3(){
    var blog = getEl('blogBody');
    var distance = Dom.getViewportHeight();
    blog.setLocation(blog.getX(), blog.getY()-distance, true, 
        .75, rollup, YAHOO.util.Easing.backIn);
}

function rollup(){
    var blog = getEl('blogBody');
    var distance = Dom.getViewportHeight();
    blog.setLocation(blog.getX(), blog.getY()+(distance*2));
    blog.setLocation(blog.getX(), blog.getY()-distance, true, 
        .75, null, YAHOO.util.Easing.backOut);
}

function doExampleLink(){
    try{
        var e = Event.getEvent();
        if(e){
            Event.stopEvent(e);
        }
        var link = Event.getTarget(e);
        showExample(link.href);
    }catch(e){} // if error occurs, standard link should work
}

function showExample(url, width, height){
    var exframe = getEl('exframe');
    exframe.dom.src = url;
    var exdiv = new YAHOO.ext.Actor('example', null, true);
    exdiv.moveIn('top');
    exdiv.play();
}

function hideExample(){
    var exdiv = new YAHOO.ext.Actor('example', null, true);
    exdiv.moveOut('top');
    exdiv.play(clearExample);
}

function clearExample(){
    getEl('exframe').dom.src = 'about:blank';
}

var PointToSplitBar = {
    animator : null,
    play : function(e){
        if(e) YAHOO.util.Event.stopEvent(e);
        if(this.animator == null){
            this.createAnimator();
        }
        this.animator.play();
    },
    
    createAnimator : function(){
        var animator = new YAHOO.ext.Animator();
        var cursor = new YAHOO.ext.Actor('cursor-img', animator);
        var resize = new YAHOO.ext.Actor('resize-img', animator);
        var click = new YAHOO.ext.Actor('click-img', animator);
        var splitter = new YAHOO.ext.Actor('splitter', animator);
        
        animator.startCapture();
        animator.addAsyncCall(Blog.navbar.undockDelegate, 1);
        cursor.show();
        cursor.moveTo(500,400);
        
        cursor.moveTo(20, getEl('navbar').getY()+10, true, .75);
        
        click.clearOpacity();
        click.show();
        click.alignTo(cursor, 'tl', [-4, -4]);
        animator.pause(.5);
        click.hide(true, .7);
        
        animator.addAsyncCall(Blog.navbar.dockDelegate, 1);
        
        cursor.alignTo('splitter', 'tr', [0, +100], true, 1);
        resize.alignTo('splitter', 'tr', [-12, +100]);
        animator.beginSync();
        cursor.hide();
        resize.show();
        animator.endSync();
        
        splitter.highlight('#EEEEFF', '#C3DAF9', .3);
        splitter.highlight('#EEEEFF', '#C3DAF9', .3);
        
        animator.pause(2);
        
        resize.hide();
        cursor.show();
        cursor.moveTo(-100, -100, true);
        
        animator.stopCapture();
        
        this.animator = animator;  
    },
    
    attach : function(){
        getEl('navDemo').on('click', this.play.createDelegate(this));
    },
    
    attach2 : function(){
        getEl('demoLink2').on('click', this.play.createDelegate(this));
    }
}

var DiggIt = {
    play : function(e){
        var animator = new YAHOO.ext.Animator();
        var link = new YAHOO.ext.Actor('digglink', animator);
        var img = new YAHOO.ext.Actor('diggit', animator);
        animator.startCapture();
        var pos = link.getXY();
        img.show();
        img.moveTo(YAHOO.util.Dom.getViewportWidth()+img.getWidth(), pos[1]);
        img.alignTo(link, 'tl', [-38, -70], true);
        link.shake();
        animator.pause(2);
        img.hide(true);
        animator.play();
    }
}

YAHOO.ext.EventManager.onDocumentReady(Blog.initUI, Blog, true);
YAHOO.util.Event.on(window, 'resize', Blog.handleResize.createDelegate(Blog));

// use onAvailable since these may not be present
YAHOO.util.Event.onAvailable('navDemo', 
    PointToSplitBar.attach.createDelegate(PointToSplitBar));
    
YAHOO.util.Event.onAvailable('demoLink2', 
    PointToSplitBar.attach2.createDelegate(PointToSplitBar));
    
//YAHOO.util.Event.onAvailable('digglink', DiggIt.play, DiggIt, true);