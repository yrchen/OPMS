/*
 * YUI Extensions
 * Copyright(c) 2006, Jack Slocum.
 * 
 * This code is licensed under BSD license. 
 * http://www.opensource.org/licenses/bsd-license.php
 */


YAHOO.namespace('ext');
YAHOO.namespace('ext.util');
YAHOO.ext.Strict = (document.compatMode == 'CSS1Compat');

/**
 * Creates a callback that passes arguments[0], arguments[1], arguments[2], ...
 * Call directly on any function. Example: <code>myFunction.createCallback(myarg, myarg2)</code>
 * Will create a function that is bound to those 2 args.
 * @addon
 * @return {Function} The new function
*/
Function.prototype.createCallback = function(/*args...*/){
    // make args available, in function below
    var args = arguments;
    var method = this;
    return function() {
        return method.apply(window, args);
    }
};

/**
 * Creates a delegate (callback) that sets the scope to obj.
 * Call directly on any function. Example: <code>this.myFunction.createDelegate(this)</code>
 * Will create a function that is automatically scoped to this.
 * @addon
 * @param {Object} obj The object for which the scope is set
 * @param {<i>Array</i>} args (optional) Overrides arguments for the call. (Defaults to the arguments passed by the caller)
 * @param {<i>Boolean</i>} appendArgs (optional) if True args are appended to call args instead of overriding
 * @return {Function} The new function
 */
Function.prototype.createDelegate = function(obj, args, appendArgs){
    var method = this;
    return function() {
        var callargs = args || arguments;
        if(appendArgs){
            callargs = Array.prototype.concat.apply(arguments, args);
        }
        return method.apply(obj || window, callargs);
    }
};

/**
 * Create a combined function call sequence of the original function + the passed function.
 * The resulting function returns the results of the original function.
 * The passed fcn is called with the parameters of the original function
 * @addon
 * @param {Function} fcn The function to sequence
 * @param {<i>Object</i>} scope (optional) The scope of the passed fcn (Defaults to scope of original function or window)
 * @return {Function} The new function
 */
Function.prototype.createSequence = function(fcn, scope){
    if(typeof fcn != 'function'){
        return this;
    }
    var method = this;
    return function() {
        var retval = method.apply(this || window, arguments);
        fcn.apply(scope || this || window, arguments);
        return retval;
    }
};

/**
 * Creates an interceptor function. The passed fcn is called before the original one. If it returns false, the original one is not called.
 * The resulting function returns the results of the original function.
 * The passed fcn is called with the parameters of the original function.
 * @addon
 * @param {Function} fcn The function to call before the original
 * @param {<i>Object</i>} scope (optional) The scope of the passed fcn (Defaults to scope of original function or window)
 * @return {Function} The new function
 */
Function.prototype.createInterceptor = function(fcn, scope){
    if(typeof fcn != 'function'){
        return this;
    }
    var method = this;
    return function() {
        fcn.target = this;
        fcn.method = method;
        if(fcn.apply(scope || this || window, arguments) === false) 
            return;
        return method.apply(this || window, arguments);;
    }
};

/**
 * @class
 * @constructor
 */
YAHOO.ext.util.Browser = new function(){
	var ua = navigator.userAgent.toLowerCase();
	/** @type Boolean */
	this.isOpera = (ua.indexOf('opera') > -1);
   	/** @type Boolean */
	this.isSafari = (ua.indexOf('webkit') > -1);
   	/** @type Boolean */
	this.isIE = (window.ActiveXObject);
   	/** @type Boolean */
	this.isIE7 = (ua.indexOf('msie 7') > -1);
   	/** @type Boolean */
	this.isGecko = !this.isSafari && (ua.indexOf('gecko') > -1);
}();

/**
 * Enable custom handler signature and event cancelling. Using fireDirect() instead of fire() calls the subscribed event handlers 
 * with the exact parameters passed to fireDirect, instead of the usual (eventType, args[], obj). IMO this is more intuitive 
 * and promotes cleaner code. Also, if an event handler returns false, it is returned by fireDirect and no other handlers will be called.<br>
 * Example:<br><br><pre><code>
 * if(beforeUpdateEvent.fireDirect(myArg, myArg2) !== false){
 *     // do update
 * }</code></pre>
 * @addon
 */
YAHOO.util.CustomEvent.prototype.fireDirect = function(){
    var len=this.subscribers.length;
    for (var i=0; i<len; ++i) {
        var s = this.subscribers[i];
        if(s){
            var scope = (s.override) ? s.obj : this.scope;
            if(s.fn.apply(scope, arguments) === false){
                return false;
            }
        }
    }
    return true;
};

YAHOO.extendX = function(subclass, superclass, overrides){
    YAHOO.extend(subclass, superclass);
    subclass.override = function(o){
        YAHOO.override(subclass, o);
    };
    subclass.prototype.override = function(o){
        for(var method in o){
            this[method] = o[method];
        }  
    };
    if(overrides){
        subclass.override(overrides);
    }
};

YAHOO.override = function(origclass, overrides){
    if(overrides){
        var p = origclass.prototype;
        for(var method in overrides){
            p[method] = overrides[method];
        }
    }
};

/**
 * @class
 * Very simple Benchmark class that supports multiple timers
 * @constructor
 */
YAHOO.ext.util.Bench = function(){
   this.timers = {};
   this.lastKey = null;
};
YAHOO.ext.util.Bench.prototype = {
   start : function(key){
       this.lastKey = key;
       this.timers[key] = {};
       this.timers[key].startTime = new Date().getTime(); 
   },
   
   stop : function(key){
       key = key || this.lastKey;
       this.timers[key].endTime = new Date().getTime(); 
   },
   
   getElapsed : function(key){
       key = key || this.lastKey;
       return this.timers[key].endTime - this.timers[key].startTime;
   },
   
   toString : function(html){
       var results = "Results: \n";
       for(var key in this.timers){
           if(typeof this.timers[key] != 'function'){
               results += key + ":\t" + (this.getElapsed(key) / 1000) + " seconds\n";
           }
       }
       if(html){
           results = results.replace("\n", '<br>');
       }
       return results;
   },
   
   show : function(){
       alert(this.toString());
   }
};

/**
 * @class
 * Provides a convenient method of performing setTimeout where a new
 * timeout cancels the old timeout. An example would be performing validation on a keypress.
 * You can use this class to buffer
 * the keypress events for a certain number of milliseconds, and perform only if they stop
 * for that amount of time.
 * @constructor The parameters to this constructor serve as defaults and are not required.
 * @param {<i>Function</i>} fn (optional) The default function to timeout
 * @param {<i>Object</i>} scope (optional) The default scope of that timeout
 * @param {<i>Array</i>} args (optional) The default Array of arguments
 */
YAHOO.ext.util.DelayedTask = function(fn, scope, args){
    var timeoutId = null;
    
    /**
     * Cancels any pending timeout and queues a new one
     * @param {Number} delay The milliseconds to delay
     * @param {Function} newFn Overrides function passed to constructor
     * @param {Object} newScope Overrides scope passed to constructor
     * @param {Array} newArgs Overrides args passed to constructor
     */
    this.delay = function(delay, newFn, newScope, newArgs){
        if(timeoutId){
            clearTimeout(timeoutId);
        }
        fn = newFn || fn;
        scope = newScope || scope;
        args = newArgs || args;
        timeoutId = setTimeout(fn.createDelegate(scope, args), delay);
    };
    
    /**
     * Cancel the last queued timeout
     */
    this.cancel = function(){
        if(timeoutId){
            clearTimeout(timeoutId);
            timeoutId = null;
        }
    };
};

YAHOO.ext.util.Observable = function(){};
YAHOO.ext.util.Observable.prototype = {
    fireEvent : function(){
        var ce = this.events[arguments[0].toLowerCase()];
        ce.fireDirect.apply(ce, Array.prototype.slice.call(arguments, 1));
    },
    addListener : function(eventName, fn, scope, override){
        eventName = eventName.toLowerCase();
        if(!this.events[eventName]){
            // added for a better message when subscribing to wrong event
            throw 'You are trying to listen for an event that does not exist: "' + eventName + '".';
        }
        this.events[eventName].subscribe(fn, scope, override);
    },
    delayedListener : function(eventName, fn, scope, delay){
        var newFn = function(){
            setTimeout(fn.createDelegate(scope, arguments), delay || 1);
        }
        this.addListener(eventName, newFn);
        return newFn;
    },
    removeListener : function(eventName, fn, scope){
        this.events[eventName.toLowerCase()].unsubscribe(fn, scope);
    }
};
YAHOO.ext.util.Observable.prototype.on = YAHOO.ext.util.Observable.prototype.addListener;
    
YAHOO.ext.util.Config = {
    apply : function(obj, config){
        if(config){
            for(var prop in config){
                if(typeof config[prop] != 'function'){
                    obj[prop] = config[prop];
                }
            }
        }
    }
};

/**
 * @class
 */
YAHOO.ext.util.CSS = new function(){
	var rules = null;
   	
   	var toCamel = function(property) {
      var convert = function(prop) {
         var test = /(-[a-z])/i.exec(prop);
         return prop.replace(RegExp.$1, RegExp.$1.substr(1).toUpperCase());
      };
      while(property.indexOf('-') > -1) {
         property = convert(property);
      }
      return property;
   };
   
   /**
    * Gets all css rules for the document
    */
   this.getRules = function(refreshCache){
   		if(rules == null || refreshCache){
   			rules = {};
   			var ds = document.styleSheets;
   			for(var i =0; i < ds.length; i++){
   			    try{
    		        var ss = ds[i];
    		        var ssRules = ss.cssRules || ss.rules;
    		        for(var j = ssRules.length-1; j >= 0; --j){
    		        	rules[ssRules[j].selectorText] = ssRules[j];
    		        }
   			    }catch(e){} // try catch for cross domain access issue
	        }
   		}
   		return rules;
   	};
   	
   	/**
    * Searches for a rule by selector
    */
   this.getRule = function(selector, refreshCache){
   		var rs = this.getRules(refreshCache);
   		if(!(selector instanceof Array)){
   		    return rs[selector];
   		}
   		for(var i = 0; i < selector.length; i++){
			if(rs[selector[i]]){
				return rs[selector[i]];
			}
		}
		return null;
   	};
   	
   	
   	/**
    * Updates a rule property
    * @param {String/Array} selector If it's an array it tries each selector until it finds one. Stops immediately once one is found.
    */
   this.updateRule = function(selector, property, value){
   		if(!(selector instanceof Array)){
   			var rule = this.getRule(selector);
   			if(rule){
   				rule.style[property] = value;
   				return true;
   			}
   		}else{
   			for(var i = 0; i < selector.length; i++){
   				if(this.updateRule(selector[i], property, value)){
   					return true;
   				}
   			}
   		}
   		return false;
   	};
   	
   	/**
    * Applies a rule to an element without adding the class
    * @param {String/Array} selector If it's an array it tries each selector until it finds one. Stops immediately once one is found.
    */
   this.apply = function(el, selector){
   		if(!(selector instanceof Array)){
   			var rule = this.getRule(selector);
   			if(rule){
   			    var s = rule.style;
   				for(var key in s){
   				    if(typeof s[key] != 'function'){
       					if(s[key] && String(s[key]).indexOf(':') < 0 && s[key] != 'false'){
       						try{el.style[key] = s[key];}catch(e){}
       					}
   				    }
   				}
   				return true;
   			}
   		}else{
   			for(var i = 0; i < selector.length; i++){
   				if(this.apply(el, selector[i])){
   					return true;
   				}
   			}
   		}
   		return false;
   	};
   	
   	this.applyFirst = function(el, id, selector){
   		var selectors = [
   			'#' + id + ' ' + selector,
   			selector
   		];
   		return this.apply(el, selectors);
   	};
   	
   	this.revert = function(el, selector){
   		if(!(selector instanceof Array)){
   			var rule = this.getRule(selector);
   			if(rule){
   				for(key in rule.style){
   					if(rule.style[key] && String(rule.style[key]).indexOf(':') < 0 && rule.style[key] != 'false'){
   						try{el.style[key] = '';}catch(e){}
   					}
   				}
   				return true;
   			}
   		}else{
   			for(var i = 0; i < selector.length; i++){
   				if(this.revert(el, selector[i])){
   					return true;
   				}
   			}
   		}
   		return false;
   	};
   	
   	this.revertFirst = function(el, id, selector){
   		var selectors = [
   			'#' + id + ' ' + selector,
   			selector
   		];
   		return this.revert(el, selectors);
   	};
}();


/*
 * All the Date functions below are the excellent work of Baron Schwartz
 */

/** @ignore */
Date.parseFunctions = {count:0};
/** @ignore */
Date.parseRegexes = [];
/** @ignore */
Date.formatFunctions = {count:0};

/**
 * Formats a date given to the supplied format - the format syntax is the same as <a href="http://www.php.net/date">PHP's date() function</a>.
 */
Date.prototype.dateFormat = function(format) {
    if (Date.formatFunctions[format] == null) {
        Date.createNewFormat(format);
    }
    var func = Date.formatFunctions[format];
    return this[func]();
};

/**
 * Same as {@link #dateFormat}
 */
Date.prototype.format = Date.prototype.dateFormat;

/** @ignore */
Date.createNewFormat = function(format) {
    var funcName = "format" + Date.formatFunctions.count++;
    Date.formatFunctions[format] = funcName;
    var code = "Date.prototype." + funcName + " = function(){return ";
    var special = false;
    var ch = '';
    for (var i = 0; i < format.length; ++i) {
        ch = format.charAt(i);
        if (!special && ch == "\\") {
            special = true;
        }
        else if (special) {
            special = false;
            code += "'" + String.escape(ch) + "' + ";
        }
        else {
            code += Date.getFormatCode(ch);
        }
    }
    eval(code.substring(0, code.length - 3) + ";}");
};

/** @ignore */
Date.getFormatCode = function(character) {
    switch (character) {
    case "d":
        return "String.leftPad(this.getDate(), 2, '0') + ";
    case "D":
        return "Date.dayNames[this.getDay()].substring(0, 3) + ";
    case "j":
        return "this.getDate() + ";
    case "l":
        return "Date.dayNames[this.getDay()] + ";
    case "S":
        return "this.getSuffix() + ";
    case "w":
        return "this.getDay() + ";
    case "z":
        return "this.getDayOfYear() + ";
    case "W":
        return "this.getWeekOfYear() + ";
    case "F":
        return "Date.monthNames[this.getMonth()] + ";
    case "m":
        return "String.leftPad(this.getMonth() + 1, 2, '0') + ";
    case "M":
        return "Date.monthNames[this.getMonth()].substring(0, 3) + ";
    case "n":
        return "(this.getMonth() + 1) + ";
    case "t":
        return "this.getDaysInMonth() + ";
    case "L":
        return "(this.isLeapYear() ? 1 : 0) + ";
    case "Y":
        return "this.getFullYear() + ";
    case "y":
        return "('' + this.getFullYear()).substring(2, 4) + ";
    case "a":
        return "(this.getHours() < 12 ? 'am' : 'pm') + ";
    case "A":
        return "(this.getHours() < 12 ? 'AM' : 'PM') + ";
    case "g":
        return "((this.getHours() %12) ? this.getHours() % 12 : 12) + ";
    case "G":
        return "this.getHours() + ";
    case "h":
        return "String.leftPad((this.getHours() %12) ? this.getHours() % 12 : 12, 2, '0') + ";
    case "H":
        return "String.leftPad(this.getHours(), 2, '0') + ";
    case "i":
        return "String.leftPad(this.getMinutes(), 2, '0') + ";
    case "s":
        return "String.leftPad(this.getSeconds(), 2, '0') + ";
    case "O":
        return "this.getGMTOffset() + ";
    case "T":
        return "this.getTimezone() + ";
    case "Z":
        return "(this.getTimezoneOffset() * -60) + ";
    default:
        return "'" + String.escape(character) + "' + ";
    };
};

/**
 * Parses a date given the supplied format - the format syntax is the same as <a href="http://www.php.net/date">PHP's date() function</a>.
 */
Date.parseDate = function(input, format) {
    if (Date.parseFunctions[format] == null) {
        Date.createParser(format);
    }
    var func = Date.parseFunctions[format];
    return Date[func](input);
};

/** @ignore */
Date.createParser = function(format) {
    var funcName = "parse" + Date.parseFunctions.count++;
    var regexNum = Date.parseRegexes.length;
    var currentGroup = 1;
    Date.parseFunctions[format] = funcName;

    var code = "Date." + funcName + " = function(input){\n"
        + "var y = -1, m = -1, d = -1, h = -1, i = -1, s = -1;\n"
        + "var d = new Date();\n"
        + "y = d.getFullYear();\n"
        + "m = d.getMonth();\n"
        + "d = d.getDate();\n"
        + "var results = input.match(Date.parseRegexes[" + regexNum + "]);\n"
        + "if (results && results.length > 0) {"
    var regex = "";

    var special = false;
    var ch = '';
    for (var i = 0; i < format.length; ++i) {
        ch = format.charAt(i);
        if (!special && ch == "\\") {
            special = true;
        }
        else if (special) {
            special = false;
            regex += String.escape(ch);
        }
        else {
            obj = Date.formatCodeToRegex(ch, currentGroup);
            currentGroup += obj.g;
            regex += obj.s;
            if (obj.g && obj.c) {
                code += obj.c;
            }
        }
    }

    code += "if (y > 0 && m >= 0 && d > 0 && h >= 0 && i >= 0 && s >= 0)\n"
        + "{return new Date(y, m, d, h, i, s);}\n"
        + "else if (y > 0 && m >= 0 && d > 0 && h >= 0 && i >= 0)\n"
        + "{return new Date(y, m, d, h, i);}\n"
        + "else if (y > 0 && m >= 0 && d > 0 && h >= 0)\n"
        + "{return new Date(y, m, d, h);}\n"
        + "else if (y > 0 && m >= 0 && d > 0)\n"
        + "{return new Date(y, m, d);}\n"
        + "else if (y > 0 && m >= 0)\n"
        + "{return new Date(y, m);}\n"
        + "else if (y > 0)\n"
        + "{return new Date(y);}\n"
        + "}return null;}";

    Date.parseRegexes[regexNum] = new RegExp("^" + regex + "$");
    eval(code);
};

/** @ignore */
Date.formatCodeToRegex = function(character, currentGroup) {
    switch (character) {
    case "D":
        return {g:0,
        c:null,
        s:"(?:Sun|Mon|Tue|Wed|Thu|Fri|Sat)"};
    case "j":
    case "d":
        return {g:1,
            c:"d = parseInt(results[" + currentGroup + "], 10);\n",
            s:"(\\d{1,2})"};
    case "l":
        return {g:0,
            c:null,
            s:"(?:" + Date.dayNames.join("|") + ")"};
    case "S":
        return {g:0,
            c:null,
            s:"(?:st|nd|rd|th)"};
    case "w":
        return {g:0,
            c:null,
            s:"\\d"};
    case "z":
        return {g:0,
            c:null,
            s:"(?:\\d{1,3})"};
    case "W":
        return {g:0,
            c:null,
            s:"(?:\\d{2})"};
    case "F":
        return {g:1,
            c:"m = parseInt(Date.monthNumbers[results[" + currentGroup + "].substring(0, 3)], 10);\n",
            s:"(" + Date.monthNames.join("|") + ")"};
    case "M":
        return {g:1,
            c:"m = parseInt(Date.monthNumbers[results[" + currentGroup + "]], 10);\n",
            s:"(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)"};
    case "n":
    case "m":
        return {g:1,
            c:"m = parseInt(results[" + currentGroup + "], 10) - 1;\n",
            s:"(\\d{1,2})"};
    case "t":
        return {g:0,
            c:null,
            s:"\\d{1,2}"};
    case "L":
        return {g:0,
            c:null,
            s:"(?:1|0)"};
    case "Y":
        return {g:1,
            c:"y = parseInt(results[" + currentGroup + "], 10);\n",
            s:"(\\d{4})"};
    case "y":
        return {g:1,
            c:"var ty = parseInt(results[" + currentGroup + "], 10);\n"
                + "y = ty > Date.y2kYear ? 1900 + ty : 2000 + ty;\n",
            s:"(\\d{1,2})"};
    case "a":
        return {g:1,
            c:"if (results[" + currentGroup + "] == 'am') {\n"
                + "if (h == 12) { h = 0; }\n"
                + "} else { if (h < 12) { h += 12; }}",
            s:"(am|pm)"};
    case "A":
        return {g:1,
            c:"if (results[" + currentGroup + "] == 'AM') {\n"
                + "if (h == 12) { h = 0; }\n"
                + "} else { if (h < 12) { h += 12; }}",
            s:"(AM|PM)"};
    case "g":
    case "G":
    case "h":
    case "H":
        return {g:1,
            c:"h = parseInt(results[" + currentGroup + "], 10);\n",
            s:"(\\d{1,2})"};
    case "i":
        return {g:1,
            c:"i = parseInt(results[" + currentGroup + "], 10);\n",
            s:"(\\d{2})"};
    case "s":
        return {g:1,
            c:"s = parseInt(results[" + currentGroup + "], 10);\n",
            s:"(\\d{2})"};
    case "O":
        return {g:0,
            c:null,
            s:"[+-]\\d{4}"};
    case "T":
        return {g:0,
            c:null,
            s:"[A-Z]{3}"};
    case "Z":
        return {g:0,
            c:null,
            s:"[+-]\\d{1,5}"};
    default:
        return {g:0,
            c:null,
            s:String.escape(character)};
    }
};

Date.prototype.getTimezone = function() {
    return this.toString().replace(
        /^.*? ([A-Z]{3}) [0-9]{4}.*$/, "$1").replace(
        /^.*?\(([A-Z])[a-z]+ ([A-Z])[a-z]+ ([A-Z])[a-z]+\)$/, "$1$2$3");
};

Date.prototype.getGMTOffset = function() {
    return (this.getTimezoneOffset() > 0 ? "-" : "+")
        + String.leftPad(Math.floor(this.getTimezoneOffset() / 60), 2, "0")
        + String.leftPad(this.getTimezoneOffset() % 60, 2, "0");
};

Date.prototype.getDayOfYear = function() {
    var num = 0;
    Date.daysInMonth[1] = this.isLeapYear() ? 29 : 28;
    for (var i = 0; i < this.getMonth(); ++i) {
        num += Date.daysInMonth[i];
    }
    return num + this.getDate() - 1;
};

Date.prototype.getWeekOfYear = function() {
    // Skip to Thursday of this week
    var now = this.getDayOfYear() + (4 - this.getDay());
    // Find the first Thursday of the year
    var jan1 = new Date(this.getFullYear(), 0, 1);
    var then = (7 - jan1.getDay() + 4);
    document.write(then);
    return String.leftPad(((now - then) / 7) + 1, 2, "0");
};

Date.prototype.isLeapYear = function() {
    var year = this.getFullYear();
    return ((year & 3) == 0 && (year % 100 || (year % 400 == 0 && year)));
};

Date.prototype.getFirstDayOfMonth = function() {
    var day = (this.getDay() - (this.getDate() - 1)) % 7;
    return (day < 0) ? (day + 7) : day;
};

Date.prototype.getLastDayOfMonth = function() {
    var day = (this.getDay() + (Date.daysInMonth[this.getMonth()] - this.getDate())) % 7;
    return (day < 0) ? (day + 7) : day;
};

Date.prototype.getDaysInMonth = function() {
    Date.daysInMonth[1] = this.isLeapYear() ? 29 : 28;
    return Date.daysInMonth[this.getMonth()];
};

/** @ignore */
Date.prototype.getSuffix = function() {
    switch (this.getDate()) {
        case 1:
        case 21:
        case 31:
            return "st";
        case 2:
        case 22:
            return "nd";
        case 3:
        case 23:
            return "rd";
        default:
            return "th";
    }
};

if(!String.escape){
    /** @ignore */
    String.escape = function(string) {
        return string.replace(/('|\\)/g, "\\$1");
    };
};

/**
 * Left pads a string to size with ch
 */
String.leftPad = function (val, size, ch) {
    var result = new String(val);
    if (ch == null) {
        ch = " ";
    }
    while (result.length < size) {
        result = ch + result;
    }
    return result;
};

if(!Object.dump){
Object.dump = function(o){
    var s = "\n{";
    for(var k in o){
        if(typeof o[k] != 'function'){
            s += "\n\t" + k + ': ' + o[k] +','; 
        }
    }
    if(s.length > 3){
      s = s.substring(0, s.length-1);
    }
    s += "\n}";
    return s;
}
}

/** @ignore */
Date.daysInMonth = [31,28,31,30,31,30,31,31,30,31,30,31];

/**
 * Override these values for international dates, for example...
 * Date.monthNames = ['JanInYourLang', 'FebInYourLang', ...];
 */
Date.monthNames =
   ["January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December"];
    
/**
 * Override these values for international dates, for example...
 * Date.dayNames = ['SundayInYourLang', 'MondayInYourLang', ...];
 */
Date.dayNames =
   ["Sunday",
    "Monday",
    "Tuesday",
    "Wednesday",
    "Thursday",
    "Friday",
    "Saturday"];

/** @ignore */
Date.y2kYear = 50;

/** @ignore */
Date.monthNumbers = {
    Jan:0,
    Feb:1,
    Mar:2,
    Apr:3,
    May:4,
    Jun:5,
    Jul:6,
    Aug:7,
    Sep:8,
    Oct:9,
    Nov:10,
    Dec:11};