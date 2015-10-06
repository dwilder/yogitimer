(function(){
    
    var maxTime         = 500,
        minOpacity      = 0.2,
        opacityChange   = 0.01,
        color0,
        color1,
        colorChange     = 0.05;
        
    var foregroundStrings           = [],
        animatedForegroundStrings   = [],
        backgroundStrings           = [],
        animatedBackgroundStrings   = [];
        
    var timerOffsets                = [],
        backgroundTimeTracker       = 0,
        nextTime                    = 0,
        cycleTime                   = 5000,
        foregroundTimeTracker       = 0,
        currentForegroundString     = 0;
    
    var generateTimerOffset = function( max ) {
        return Math.floor( Math.random() * max );
    }
    
    var animateForegroundStrings = function(dt) {
        foregroundTimeTracker += dt;
        if ( foregroundTimeTracker > cycleTime ) {
            foregroundTimeTracker = 0;
            currentForegroundString = ( currentForegroundString + 1 == foregroundStrings.length ) ? 0 : currentForegroundString + 1;
        }
        foregroundStrings[currentForegroundString].animate();
    }
    
    var animateBackgroundStrings = function(dt) {
        
        if ( timerOffsets != null ) {
            backgroundTimeTracker += dt;
            if ( backgroundTimeTracker >= nextTime ) {
                nextTime += timerOffsets.pop();
                animatedBackgroundStrings.push( backgroundStrings.pop() );
                
                if ( timerOffsets.length == 0 ) {
                    timerOffsets = null;
                    
                }
            }
        }
        
        for ( var i = 0; i < animatedBackgroundStrings.length; i++ ) {
            animatedBackgroundStrings[i].animate();
        }
    }
    
    var animate = function() {
        var now, then = new Date(), dt;
        var int = setInterval( function() {
            now = new Date();
            dt = now - then;
            
            animateForegroundStrings(dt);
            animateBackgroundStrings(dt);
            
            then = now;
        }, 1000/60 );
    }
    
    var banner = {
        banner : null,
        width  : null,
        height : null,
        init : function() {
            this.banner = document.getElementById('banner');
            this.setDimensions();
            U.addEvent( window, 'resize', this.setDimensions );
        },
        setDimensions : function() {
            this.width = this.banner.offsetWidth;
            this.height = this.banner.offsetHeight;
        }
    };
    
    var foregroundString = function(obj) {
        
        this.obj = obj;
        this.animationStage;
        this.top;
        this.left;
        this.fontSize;
        
        this.init = function() {
            this.animationStage = 3;
            this.opacity = 0;
            
            var style = window.getComputedStyle( this.obj );
            this.color  = style.getPropertyValue('color');
            this.fontSize = style.getPropertyValue('font-size').replace('px','');

            this.setBasePosition();
            
            this.obj.style.opacity = this.opacity;
        }
        this.setBasePosition = function() {
            var style = window.getComputedStyle( this.obj );

            this.top    = style.getPropertyValue('top').replace('px', '');
            this.left   = style.getPropertyValue('left').replace('px', '');
            
            if ( this.left == 'auto' ) {
                var r = style.getPropertyValue('right').replace('%', '');
                // Convert to px
                this.left = ( 1 - r / 100) * banner.width - this.obj.offsetWidth;
            }
        }
        this.animate = function() {
            
            var dt = cycleTime - foregroundTimeTracker;
            
            // Stage 1: fade the color
            if ( foregroundTimeTracker < cycleTime/2 ) {
            
                // Show the string
                if ( this.animationStage == 3 ) {
                    this.animationStage     = 1;
                    
                    this.obj.style.top      = '';
                    this.obj.style.left     = '';
                    this.obj.style.fontSize  = '';
                    
                    this.opacity = 0;
                    this.obj.style.color = color0;
                }
                
                this.animationStage = 2;
                if ( dt > 4 * cycleTime / 5 ) {
                    this.opacity = 5 * ( 1 - dt / cycleTime );
                }
                this.obj.style.opacity = this.opacity;
                
            }
            // Stage 3: fade opacity
            else {
                this.animationStage = 3;
                this.opacity = 2 * ( 1 - foregroundTimeTracker / cycleTime );
                this.obj.style.opacity = this.opacity;
            }
        }
        this.init();
    }
    
    var backgroundString = function(obj) {
        this.obj = obj;
        this.init = function() {
            this.opacity    = 0;
            this.up         = false;
            this.obj.style.opacity = this.opacity;
        }
        this.animate = function() {
            if ( this.opacity >= 1 ) {
                this.up = false;
            } else if ( this.opacity < 0.1 ) {
                this.up = true;
            }
            
            if ( this.up ) {
                this.opacity += opacityChange;
                this.obj.style.opacity = this.opacity;
            } else {
                this.opacity -= opacityChange;
                this.obj.style.opacity = this.opacity;
            }
        }
        this.init();
    }
    
    var initBannerForeground = function() {
        var strings = document.getElementById('banner-foreground').getElementsByTagName('span');
        for ( var i = 0; i < strings.length; i++ ) {
            foregroundStrings.push( new foregroundString( strings[i] ) );
        }
        color0 = foregroundStrings[0].color;
        color1 = foregroundStrings[1].color;
    }
    
    var initBannerBackground = function() {
        var strings = document.getElementById('banner-background').getElementsByTagName('span');
        for ( var i = 0; i < strings.length; i++ ) {
            backgroundStrings.push( new backgroundString( strings[i] ) );
            timerOffsets.push( generateTimerOffset(maxTime) );
        }
        timerOffsets.pop();
        animatedBackgroundStrings.push( backgroundStrings.pop() );
    }
    
    var initBanner = function() {
        banner.init();
        initBannerForeground();
        initBannerBackground();
        animate();
    }
    
    var init = function() {
        initBanner();
    }
    
    window.onload = init;
})();