/**
 * Copyright 2006 Jack Slocum
 * Want to use this code on your site? Of course you can!
 * This code, like all code on http://www.jackslocum.com/ is
 * free to modify and distribute as you wish.
 * http://www.opensource.org/licenses/bsd-license.php
 */

var Commentable = function(){
    /* private variables */
    var cb, blocks, tpl, cn, tabs, wait, list, vlist, error, submit;
    var cmResize, viewResize;
    var posting = false;
    var currentIndex, lastIndex;
    var state = YAHOO.ext.state.Manager;
    state.setProvider(new YAHOO.ext.state.CookieProvider());
    
    /* private functions */
    var isOnCommentBar = function(e){
        var eventX = e.getPageX();
        var x = cb.getX();
        return(eventX >= x && eventX <= (x+20));
    };
    
    var setActiveIndex = function(index){
        index = index || 0;
        if(index != currentIndex){
            if(typeof currentIndex != 'undefined'){
                YAHOO.util.Dom.removeClass(blocks[currentIndex].el, 'active-content');
            }
            currentIndex = index;
            YAHOO.util.Dom.addClass(blocks[currentIndex].el, 'active-content');
        }
    };
    
    var onDoubleClick = function(e){
        if(isOnCommentBar(e)){
            var p = e.findTarget('content', 'div');
            if(p){
                e.stopEvent();
                setActiveIndex(p.contentIndex);
                Commentable.addComment();
            }
        }
    };
    
    var cancelSelection = function(e){
        if(isOnCommentBar(e)){
            e.preventDefault();
        }
    };
    
    var afterSuccess = function(el){
        blocks[currentIndex].addComment(el);
    }
    
    var commentSuccess = function(o){
        posting = false;
        var text = o.responseText;
        // if we got a comment block back
        if(text.substr(0, 3) == '<li'){
            var el = YAHOO.ext.DomHelper.insertHtml('beforeEnd', list.dom, text);
            wait.removeClass('active-msg');
            cn.hide(blocks[currentIndex], afterSuccess.createCallback(el));
        }else{
            getEl('post-error-msg').update(text);
            error.radioClass('active-msg');
        }
    };
    
    var commentFailure = function(o){
        posting = false;
        var msg = getEl('post-error-msg');
        msg.update('Error: Unable to connect.');
        error.radioClass('active-msg');
    };
    
    var loadComments = function(index){
        if(blocks){
            block = blocks[index];
            vlist.innerHTML = '';
            for(var i = 0, len = block.count; i < len; i++){
                vlist.appendChild(block.comments[i].cloneNode(true));
            }
            vlist.parentNode.scrollTop = 0;
            tabs.getTab('cview-tab').setText('Block Comments ('+block.count+')');
        }
    };
    
    var handleKey = function(e){
        var key = e.charCode || e.keyCode;
        if(key == YAHOO.ext.EventObject.ESC && cn.isVisible()){
            Commentable.closeComment();
        }    
    };
    
    var listClick = function(e){
        var t = e.findTarget('csel');
        if(t){
            var index = t.getAttribute('contentIndex');
            setActiveIndex(index);
            Commentable.scrollIntoView(document.getElementById('blogBody'), blocks[currentIndex].el);
            loadComments(currentIndex);
        }
    };
    
    /* public functions */
    return {
        init : function(){
            if(!document.getElementById('comment-tabs')){
                return;
            }
            wait = getEl('posting-wait');
            error = getEl('post-error');
            submit = getEl('comment-submit');
            vlist = document.getElementById('comment-view-list');
            
            var bd = document.body;
            bd.appendChild(document.getElementById('comment-cn'));
            
            tabs = new YAHOO.ext.TabPanel('comment-tabs');
            tabs.addTab('cform-tab', "Post a Comment");
            tabs.addTab('cview-tab', "Block Comments");
            tabs.addTab('call-tab', "All Comments");
            tabs.addTab('chelp-tab', "Help");
            tabs.onTabChange.subscribe(function(tp, tabItem){
                currentIndex = currentIndex || 0;
                if(tabItem.id == 'cform-tab'){
                    submit.show();
                    return;
                }else if(tabItem.id == 'cview-tab'){
                    loadComments(currentIndex);
                }
                submit.hide();
            });
            tabs.activate('cview-tab');
            
            cn = new CDialog('comment-cn');
            cn.resizer.delayedListener('resize', function(r, width, height){
                getEl('comment').setSize(width-40, height-255);
                tabs.bodyEl.setSize(width-12,height-90);
            });
            cn.restoreState();
            
            cb = getEl('commentable-body');
            cb.mon('click', onDoubleClick);
            cb.mon('mousedown', cancelSelection);
            cb.mon('selectstart', cancelSelection);
            
            blocks = [];
            var paras = YAHOO.util.Dom.getElementsByClassName('content', 'div', cb.dom);
            for(var i = 0, len = paras.length; i < len; i++){
                blocks[i] = new CBlock(paras[i], i);
            }
            
            list = getEl('comment-items');
            list.mon('click', listClick);
            var items = list.dom.getElementsByTagName('li');
            for(var i = 0, len = items.length; i < len; i++){
                blocks[items[i].getAttribute('contentIndex')].addComment(items[i]);
            }          
        },
        
        addComment : function(){
            var block = blocks[currentIndex || 0];
            this.showComments(block, 'cform-tab');
        },
        
        addGeneralComment : function(){
            if(!blocks) return; // still initializing
            setActiveIndex(0);
            this.addComment();  
        },
        
        showHelp : function(){
            if(!blocks) return; // still initializing
            setActiveIndex(0);
            this.showComments(blocks[0], 'chelp-tab'); 
        },
        
        submitComment : function(){
            if(posting) return;
            var f = document.getElementById('commentform');
            wait.radioClass('active-msg');          
            YAHOO.util.Connect.setForm(f);
            posting = true;
            YAHOO.util.Connect.asyncRequest('POST', '/yui/wp-comments-post.php', 
                    {success: commentSuccess, failure: commentFailure});          
        },
        
        closeComment : function(){
            wait.removeClass('active-msg');
            error.removeClass('active-msg');
            cn.hide(blocks[currentIndex]);
            YAHOO.util.Event.removeListener(document, 'keydown', handleKey);
        },
        
        showAllComments : function(){
            if(!blocks)return; // still initializing
            setActiveIndex(0);
            this.showComments(blocks[0], 'call-tab');  
        },
        
        commentMarkClick : function(block){
            if(block.index == currentIndex && cn.isVisible()){
                this.closeComment();
            }else{
                this.showComments(block);
            } 
        },
        
        showComments : function(block, tab){
            tabs.activate(tab || 'cview-tab');
            setActiveIndex(block.index);
            tabs.getTab('call-tab').setText('All Comments ('+list.dom.childNodes.length+')');
            var f = document.getElementById('commentform');
            f.elements['contentIndex'].value = currentIndex;
            f.elements['comment'].value = '';
            loadComments(block.index);
            list.dom.parentNode.scrollTop = 0;
            YAHOO.util.Event.on(document, 'keydown', handleKey);
            cn.show(block);
        },
        
        scrollIntoView : function(container, child){
            var childTop = parseInt(child.offsetTop, 10);
            var childBottom = childTop + child.offsetHeight;
            var containerTop = parseInt(container.scrollTop, 10); // parseInt for safari bug
            var containerBottom = containerTop + container.clientHeight;
            if(childTop < containerTop){
            	container.scrollTop = childTop;
            }else if(childBottom > containerBottom){
                container.scrollTop = childBottom-container.clientHeight;
            }
        }
    };
}();
YAHOO.ext.EventManager.onDocumentReady(Commentable.init, Commentable, true);

var CDialog = function(el){
    this.el = getEl(el);
    this.size = this.el.getSize();
    this.xy = this.el.getCenterXY();
    this.resizer = new YAHOO.ext.Resizable(this.el, {minWidth:450, minHeight:300, disableTrackOver:true, multiDirectional: true});
    this.initialized = false;
    this.proxy = getEl(YAHOO.ext.DomHelper.append(this.el.dom.parentNode, 
                {tag : 'div', cls: 'dialog-proxy'}), true);
    this.proxy.setOpacity(.5);
    //this.restoreState();
    this.el.setStyle('display', 'none');
    this.windowResizeTask = new YAHOO.ext.util.DelayedTask(this.adjustViewport, this);
    var resizeDelegate = this.windowResizeTask.delay.createDelegate(this.windowResize, [200]);
    YAHOO.util.Event.on(window, 'resize', resizeDelegate);
};

CDialog.prototype = {
    restoreState : function(){
        var box = YAHOO.ext.state.Manager.get('cnstate');
        if(box && box.width){
            this.xy = [box.x, box.y];
            this.size = box;
            this.el.setLocation(box.x, box.y);
            this.resizer.resizeTo(box.width, box.height);
            this.adjustViewport();
        }else{
            this.resizer.resizeTo(this.size.width, this.size.height);
            this.adjustViewport();
        }
    },
    
    show : function(block){
        if(!this.initialized){
            this.resizer.delayedListener('resize', this.refreshSize, this, true);
            var dd = new YAHOO.util.DDProxy(this.el.dom, 'WindowDrag', {dragElId: this.proxy.id});
            dd.setHandleElId(this.el.id + '-hd');
            dd.endDrag = this.endMove.createDelegate(this);
            dd.startDrag = this.constraints.createDelegate(this);
            //dd.onDrag = this.onDrag.createDelegate(this);
            this.initialized = true;
            this.dd = dd;
        }
        YAHOO.util.Dom.addClass(block.el, 'active-content');
        if(!this.el.isVisible()){
            this.proxy.setXY(block.getXY());
            this.proxy.setSize(20, 20);
            this.proxy.show();
            this.proxy.setBounds(this.xy[0], this.xy[1], this.size.width, this.size.height, true, .35, this.showEl.createDelegate(this));
        }
    },
    
    showEl : function(){
        this.el.setStyle('display', 'block');
        this.el.setBox(this.proxy.getBox());
        this.el.show();
        this.proxy.hide();
    },
    
    constraints : function(){
        this.dd.resetConstraints();
        this.viewSize = [YAHOO.util.Dom.getViewportWidth(),YAHOO.util.Dom.getViewportHeight()];
        this.dd.setXConstraint(this.xy[0], this.viewSize[0]-this.xy[0]-this.size.width);
        this.dd.setYConstraint(this.xy[1], this.viewSize[1]-this.xy[1]-this.size.height);
    },
    
    adjustViewport : function(){
        this.viewSize = [YAHOO.util.Dom.getViewportWidth(),YAHOO.util.Dom.getViewportHeight()];
        var moved = false;
        if(this.xy[0] + this.size.width > this.viewSize[0]){
            this.xy[0] = this.viewSize[0] - this.size.width;
            moved = true;
        }
        if(this.xy[1] + this.size.height > this.viewSize[1]){
            this.xy[1] = this.viewSize[1] - this.size.height;
            moved = true;
        }
        if(moved){
            this.el.setXY(this.xy);
        }    },
    
    endMove : function(){
        if(this.willDock){
            this.el.setWidth(this.viewSize[0]-8);
            this.el.setLocation(5, this.viewSize[1]-this.size.height-4);
            var bb = getEl('blogBody');
            bb.setHeight(bb.getHeight()-this.size.height-8);
        }else{
            YAHOO.util.DDProxy.prototype.endDrag.apply(this.dd, arguments);
        }
        this.refreshSize();
    },
    
    /*
    onDrag : function(){
        var box = this.proxy.getBox();
        if((box.y + box.height + 10) > this.viewSize[1]){
            this.proxy.setBounds(0, this.viewSize[1]-box.height, this.viewSize[0], box.height);
            this.willDock = true;
        }else{
            this.proxy.setSize(this.size.width, this.size.height);
            this.willDock = false;
        }
    },
    */
    
    isVisible : function(){
        return this.el.isVisible();    
    },
    
    hide : function(block, callback){
        YAHOO.util.Dom.removeClass(block.el, 'active-content');
        this.proxy.setBounds(this.xy[0], this.xy[1], this.size.width, this.size.height);
        var p = block.getXY();
        this.proxy.show();
        this.el.hide();
        this.el.setStyle('display', 'none');
        this.proxy.setBounds(p[0], p[1], 20, 20, true, .35, this.hideEl.createDelegate(this, [callback]));
    },
    
    hideEl : function(callback){
        this.proxy.hide();
        if(typeof callback == 'function'){
            callback();
        }
    },
    
    refreshSize : function(){
        this.size = this.el.getSize();
        this.xy = this.el.getXY();
        YAHOO.ext.state.Manager.set('cnstate', this.el.getBox());
    }
};

var CBlock = function(el, index){
    this.el = el;
    el.contentIndex = index;
    this.index = index;
    this.count = 0;
};

CBlock.prototype = {
    addComment : function(commentItem){
        if(!this.comments){
            this.comments = [];
        }
        this.comments.push(commentItem);
        this.count++;
        this.updateMark();
    },
    
    updateMark : function(){
        if(this.mark == null){
            this.mark = getEl(YAHOO.ext.DomHelper.append(this.el, 
                {tag : 'span', cls: 'comment-mark', id: 'mark-' + this.index, contentIndex: this.index, children: [
                    {tag : 'span', cls: 'comment-mark-text'}
                ]}));
            this.mark.mon('click', this.onClick, this, true);
            this.mark.mon('dblclick', function(e){e.stopEvent();});
        }
        this.mark.dom.firstChild.innerHTML = this.count;
        this.mark.dom.title = this.count == 1 ? '1 comment' : this.count + ' comments';
        //alert(this.el.innerHTML)
        
    },
    
    getXY : function(){
        return YAHOO.util.Dom.getXY(this.el);
    },
    
    onClick : function(e){
        e.stopEvent();
        this.mark.setOpacity(.5);
        Commentable.commentMarkClick(this);
    }
};