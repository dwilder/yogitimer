(function() {
    
    'use strict';
    
    
    function toggleOverlays() {
        'use strict';
        
        var m_toggle_div = U.$('profile-momentum').getElementsByTagName('div')[0];
        var m_overlay = U.$('profile-data-momentum-overlay');
        var s_toggle_div = U.$('profile-stability').getElementsByTagName('div')[0];
        var s_overlay = U.$('profile-data-stability-overlay');
        
        U.addEvent( m_toggle_div, 'click', toggler(m_overlay) );
        U.addEvent( s_toggle_div, 'click', toggler(s_overlay) );
        
        var toggler = function( target ) {
            'use strict'
           
            if ( target.style.display == 'block' ) {
                target.style.display = 'none';
            }
            else {
                target.style.display = 'block';
            }
        }
        
        
    }
    
    function momentumOverlay() {
        'use strict';
        
        var m_toggle_div = U.$('profile-momentum').getElementsByTagName('div')[0];
        
        U.addEvent( m_toggle_div, 'click', function(e) {
            'use strict'
           
            var overlay_m = U.$('profile-data-momentum-overlay');
            var current_opacity = 0;
            var opacity = 1;
            if ( overlay_m.style.display == 'block' ) {
                
                current_opacity = 1;
            
                var toggle_int = setInterval( function() {
                    current_opacity = current_opacity - 0.1;
                    overlay_m.style.opacity = current_opacity;
                    if ( current_opacity <= 0 ) {
                        clearInterval( toggle_int );
                        overlay_m.style.display = 'none';
                    }
                }, 20);
                
            }
            else {
                
                overlay_m.style.display = 'block';
                current_opacity = 0;
            
                var toggle_int = setInterval( function() {
                    current_opacity = current_opacity + 0.1;
                    overlay_m.style.opacity = current_opacity;
                    if ( current_opacity >= 1 ) {
                        clearInterval( toggle_int );
                    }
                }, 20);
                
            }
            
        });
        
    }
    
    function stabilityOverlay() {
        'use strict';
        
        var s_toggle_div = U.$('profile-stability').getElementsByTagName('div')[0];
        
        U.addEvent( s_toggle_div, 'click', function(e) {
            'use strict'
           
            var overlay_s = U.$('profile-data-stability-overlay');
            var current_opacity = 0;
            var opacity = 1;
            if ( overlay_s.style.display == 'block' ) {
                
                current_opacity = 1;
            
                var toggle_int = setInterval( function() {
                    current_opacity = current_opacity - 0.1;
                    overlay_s.style.opacity = current_opacity;
                    if ( current_opacity <= 0 ) {
                        clearInterval( toggle_int );
                        overlay_s.style.display = 'none';
                    }
                }, 20);
                
            }
            else {
                
                overlay_s.style.display = 'block';
                current_opacity = 0;
            
                var toggle_int = setInterval( function() {
                    current_opacity = current_opacity + 0.1;
                    overlay_s.style.opacity = current_opacity;
                    if ( current_opacity >= 1 ) {
                        clearInterval( toggle_int );
                    }
                }, 20);
                
            }
            
        });
        
    }
    
    function animateMomentum() {
    
        'use strict';
        var div_m = U.$('profile-data-momentum');
        var momentum = div_m.getAttribute('data-momentum');
        var side_m = div_m.height;
        
		//var start_m = new Date();
        var now_m = new Date;
        var elapsed_m = 0;
        var old_t = 0;
        var d_t = 0;
        var time_m = 0;
        
        var path_radius_m = 0;
        var path_center_m = 0;
        var ball_radius_m = 16;
        var theta = 0;
        var dampen = false;
        var force = false;
        var accel_m = 2.5;
        var padding_m = 40;
        var m_x = 0, m_y = 0; // Display x and y
        
        var dir_m = 1;
        var dir_y = 1; // Clockwise (-1 = CCW)
        var dir_x = 1;
        var y_max = 1;
        var old_y = 1, new_y = 1;
        var old_x = 0, new_x = 0;
        var d_y = 0, d_x = 0;
        var v_max = 0;
        var v_r = 0; // Radial velocity
        var d_v = 0;
        var v_maxed = false;
        
        if ( ! U.canvasSupport() ) {
            U.log( 'Canvas is not supported' );
            return false;
        }
    
        var canvas_m = div_m.getElementsByTagName( 'canvas' )[0];
        if ( ! canvas_m.getContext('2d') ) {
            U.log('Cannot get canvas context.');
            return false;
        }
        var context_m = canvas_m.getContext('2d');
        
        U.addEvent( window, 'resize', redrawCanvasM );
        
        function redrawCanvasM() {
            setCanvasMSize();
            resetMomentum();
            drawCanvasM();
        }

        // If the momentum is below 50, friction is applied until it becomes a pendulum with y_max height
        // If the momentum is above 50, force is applied until it has circular motion of a given velocity
        function calculateYMax() {
            if ( momentum < 50 ) {
                dampen = true;
                y_max = -1 + 2 * momentum / 50;
            }
        }
        function calculateVMax() {
            if ( momentum >= 50 ) {
                force = true;
                v_max = 2 * Math.sqrt( accel_m ) * momentum/49;
            }
        }
        
        function setCanvasMSize() {
            'use strict';
            side_m = div_m.clientHeight;
    		canvas_m.height = side_m;
    		canvas_m.width = side_m;

            ball_radius_m = Math.floor( side_m/15 + 1 );
            path_radius_m = Math.floor( side_m/2 - side_m/10 - ball_radius_m/2 );
            path_center_m = Math.floor( side_m/2 );
        }
        
        function drawCanvasM() {
            
            'use strict';
            
            context_m.clearRect( 0, 0, side_m, side_m );
            context_m.beginPath();
            context_m.fillStyle = "#D0CFD7";
            
            m_x = path_center_m + path_radius_m * Math.sin( theta );
            m_y = path_center_m - path_radius_m * Math.cos( theta );
            
    		context_m.arc(
                m_x,
                m_y,
                ball_radius_m, 
                (Math.PI/180)*0,
                (Math.PI/180)*360,
                false 
            );
		
    		context_m.fill();
    		context_m.closePath();
        }
        
        function resetMomentum() {
            old_t = now_m;
            theta = Math.PI/180;
            new_y = Math.cos(theta);
            new_x = Math.sin(theta);
            
            v_r = 0;
        }
        
        function setTheta() {
            'use strict';
            
            // Kick start
            if ( old_t == 0 ) {
                resetMomentum();
            }
            
            // Change in time
            d_t = (now_m - old_t)/1000;
            old_t = now_m;
            
            // Change in velocity
            d_v = accel_m * d_t * Math.sin( theta );
            
            // Apply dampening where needed
            if ( dampen == true ) {
                if ( new_y > y_max && ( (new_x < 0 && v_r > 0) || (new_x > 0 && v_r < 0) ) ) {
                    d_v = d_v*2;
                }
            }
            
            // Apply force where needed (on the downward slope)
            if ( force == true ) {
                if ( new_x > 0 ) {
                    d_v = d_v * ( 2 - v_r / v_max );
                }
            }
            
            // New velocty
            v_r = v_r + d_v;
            
            // Remove forcing
            if ( force == true ) {
                if ( v_r >= v_max ) {
                    v_r = v_max;
                    force == false;
                }
            }
            
            // New X and Y
            new_y = new_y - v_r * d_t * Math.sin( theta );
            new_x = new_x + v_r * d_t * Math.cos( theta );
            
            // Make sure nothing goes out of bounds
            if ( new_x > 1 ) {
                new_x = 2 - new_x;
            }
            else if ( new_x < -1 ) {
                new_x = -2 - new_x;
            }
            if ( new_y > 1 ) {
                new_y = 2 - new_y;
            }
            else if ( new_y < -1 ) {
                new_y = -2 - new_y;
            }
            
            // Keep theta within a circle from (5/4)PI and -(3/4)PI
            var PI = Math.PI;
            if ( theta > PI*5/4 ) {
                theta = - 2*PI + theta;
            }
            else if ( theta < - PI*3/4 ) {
                theta = 2*PI - theta;
            }
            
            // Calculate theta based on the PI
            if ( theta < -PI/4 ) {
                theta = - Math.acos( new_y );
            }
            else if ( theta < 0 ) {
                theta = Math.asin( new_x );
            }
            else if ( theta < PI * 3/4 ) {
                theta = Math.acos( new_y );
            }
            else {
                theta = PI/2 + ( PI/2 - Math.asin( new_x ) );
            }

        }
        
        
        function displayMomentum() {
            'use strict';
            var int_m = setInterval( function() {
                now_m = new Date();
                setTheta();
                drawCanvasM();
            }, 20 );
        }
        
        calculateYMax();
        calculateVMax();
        
        setCanvasMSize();
        
        displayMomentum();
    }

    function animateStability() {
    
        'use strict';
        var div_s = U.$('profile-data-stability');
        var stability = div_s.getAttribute('data-stability');
        var side_s = div_s.height;

        var ball_radius_s = 16;
        var padding_s = 40;
        var top_side, right_side, bottom_side, left_side;
        
        var motion;
        var restart_counter = 0;
        
        var accel_marker = 0;
        var attraction = 0; // Attraction to the center
        var max_accel = 100;
        var accel_x = 0;
        var accel_y = 0;
        var pull_x = 0;
        var pull_y = 0;
        
        var max_v = 300;
        var v_x = 0;
        var v_y = 0;
        var d_v_x = 0;
        var d_v_y = 0;
        
        var s_x = 0;
        var s_y = 0;
        var stable_x;
        var stable_y;

        var now = new Date;
        //var now = 0;
        var old_t = 0;
        var d_t = 0;
        
        if ( ! U.canvasSupport() ) {
            U.log( 'Canvas is not supported' );
            return false;
        }
        
        var canvas_s = div_s.getElementsByTagName( 'canvas' )[0];
        if ( ! canvas_s.getContext('2d') ) {
            U.log('Cannot get canvas context.');
            return false;
        }
        var context_s = canvas_s.getContext('2d');

        function setMaximums() {
            if ( stability >= 50 ) {
                max_accel = max_accel + 60 - stability;
                max_v = max_v - stability * 2;
            }
        }
        
        function shouldStabilize() {
            'use strict';
            
            if ( stability == 0 ) {
                return false;
            }
            
            var restart = Math.random();
            restart = Math.pow( restart, stability  );
            
            if ( restart < 0.15 ) {
                return true;
            }
            return false;
            
        }
        
        function setCanvasSSize() {
            'use strict';
            side_s = div_s.clientHeight;
    		canvas_s.height = side_s;
    		canvas_s.width = side_s;

            ball_radius_s = Math.floor( side_s/15 + 1 );
        }
        
        function drawCanvasS() {
            
            'use strict';
            
            context_s.clearRect( 0, 0, side_s, side_s );
            context_s.beginPath();
            context_s.fillStyle = "#D0CFD7";
            
    		context_s.arc(
                s_x,
                s_y,
                ball_radius_s, 
                (Math.PI/180)*0,
                (Math.PI/180)*360,
                false 
            );
		
    		context_s.fill();
    		context_s.closePath();
        }
        
        var physics = {
            
            stable: function() {
                s_x = side_s/2;
                s_y = s_x;
            },
            
            random: function() {
                'use strict';
                
                // Set acceleration
                if ( accel_marker == 0 ) {
                
                    // Set change in acceleration
                    accel_x += generateAccelerationChange( v_x );
                    accel_y += generateAccelerationChange( v_y );

                    if ( accel_x > max_accel ) {
                        accel_x = max_accel;
                    }
                    else if ( accel_x < ( -1 * max_accel ) ) {
                        accel_x = ( -1 * max_accel );
                    }
            
                    if ( accel_y > max_accel ) {
                        accel_y = max_accel;
                    }
                    else if ( accel_y < ( -1 * max_accel ) ) {
                        accel_y = ( -1 * max_accel );
                    }
                    accel_marker = 70;
                }
                accel_marker--;


                // Set attraction to the center
                pull_x = generatePull( s_x, v_x, accel_x );
                pull_y = generatePull( s_y, v_y, accel_y );
            
            
                // Set velocities
                v_x = v_x + accel_x * d_t + pull_x * d_t;
                v_y = v_y + accel_y * d_t + pull_y * d_t;

                if ( v_x > max_v ) {
                    v_x = max_v;
                }
                else if ( v_x < ( -1 * max_v ) ) {
                    v_x = ( -1 * max_v );
                }
            
                if ( v_y > max_v ) {
                    v_y = max_v;
                }
                else if ( v_y < ( -1 * max_v ) ) {
                    v_y = ( -1 * max_v );
                }

                //U.log( v_y );
                // Set position
                s_x = s_x + v_x * d_t;
                s_y = s_y + v_y * d_t;

                if ( s_x < left_side ) {
                    s_x = left_side;
                    v_x *= -1;
                    accel_x *= -1;
                }
                else if ( s_x > right_side ) {
                    s_x = right_side;
                    v_x *= -1;
                    accel_x *= -1;
                }
            
                if ( s_y < top_side ) {
                    s_y = top_side;
                    v_y *= -1;
                    accel_y *= -1;
                }
                else if ( s_y > bottom_side ) {
                    s_y = bottom_side;
                    v_y *= -1;
                    accel_y *= -1;
                }
        
                if ( restart_counter == 200 ) {

                    restart_counter = 0;
            
                    if ( shouldStabilize() ) {
                        stable_x = calculateRestartPosition();
                        stable_y = calculateRestartPosition();
                        if ( stable_x < left_side ) {
                            stable_x = left_side;
                        }
                        else if ( stable_x > right_side ) {
                            stable_x = right_side;
                        }
            
                        if ( stable_y < top_side ) {
                            stable_y = top_side;
                        }
                        else if ( stable_y > bottom_side ) {
                            stable_y = bottom_side;
                        }
                        //U.log('stabilizing');
                        motion = physics.stabilize;
                    }
                }
                restart_counter++;
                
            },
            
            stabilize: function() {
                accel_x = ( stable_x - s_x );
                accel_y = ( stable_y - s_y );

                //U.log ( 'accel_x: ' + accel_x + 'accel_y: ' + accel_y );
                if ( ( stable_x > s_x && v_x < 0 ) || ( stable_x < s_x && v_x > 0 ) ) {
                    v_x = v_x + accel_x * d_t * 10;
                }
                else {
                    v_x = v_x + accel_x * d_t;
                }
                if ( ( stable_y > s_y && v_y < 0 ) || ( stable_y < s_y && v_y > 0 ) ) {
                    v_y = v_y + accel_y * d_t * 10;
                }
                else {
                    v_y = v_y + accel_y * d_t;
                }
                
                s_x = s_x + v_x * d_t;
                s_y = s_y + v_y * d_t;

                if ( s_x < left_side ) {
                    s_x = left_side;
                    v_x *= -1;
                }
                else if ( s_x > right_side ) {
                    s_x = right_side;
                    v_x *= -1;
                }
            
                if ( s_y < top_side ) {
                    s_y = top_side;
                    v_y *= -1;
                }
                else if ( s_y > bottom_side ) {
                    s_y = bottom_side;
                    v_y *= -1;
                }
                
                if ( ( accel_x < 0.01 ) && ( accel_y < 0.01 ) ) {
                    if ( ! shouldStabilize() ) {
                        //U.log('randomizing');
                        motion = physics.random;
                    }
                }
            }
        }
        
        function setMotion() {
            // Change in time
            d_t = (now - old_t)/1000;
            old_t = now;
            
            motion();
        }
        
        function generateAccelerationChange( velocity ) {
            var accel = ( 2 * Math.random() - 1 ) * ( 100 - stability ) * Math.pow( 1 + Math.abs( velocity ), 2 );
            return accel;
        }
        
        function generatePull( position, velocity, accel ) {
            var pull = ( side_s/2 - position );
            if ( pull > 0 ) {
                var sign = 1;
            }
            else {
                var sign = -1;
            }
            pull = stability * sign;
            return pull;
        }
        
        function resetStability() {
            setCanvasSSize();
            
            if ( stability == 100 ) {
                motion = physics.stable;
            }
            else {
                motion = physics.random;
            }
            
            old_t = now;
            
            // Set bounds
            top_side = Math.floor( side_s/15 + ( ball_radius_s/2 ) );
            left_side = top_side;
            right_side = side_s - left_side;
            bottom_side = side_s - top_side;
            
            // Initial acceleration, velocity, and position
            accel_x = accel_y = 0;
            v_x = v_y = 0;
            setPositions();
        }
        
        function setPositions() {
            s_x = calculateRestartPosition();
            s_y = calculateRestartPosition();
        }
        
        function calculateRestartPosition() {
            if ( stability < 50 ) {
                
                var alpha = Math.random();
                var sign = Math.random();
                if ( sign > 0.5 ) {
                    sign = 1;
                }
                else {
                    sign = -1;
                }
                
                return side_s/2 + sign * ( side_s/2 ) * ( Math.pow( alpha, ( 1 + stability/4 ) ) );
            }
            else {
                return side_s/2;
            }
        }
        
        function displayStability() {
            'use strict';
            var int_s = setInterval( function() {
                now = new Date();
                //setVariables();
                setMotion();
                drawCanvasS();
            }, 20 );
        }
        
        setMaximums();
        resetStability();
        displayStability();
    
    }
    
    window.onload = function() {
        //toggleOverlay();
        momentumOverlay();
        stabilityOverlay();
        animateMomentum();
        animateStability();
    }
    
})();
