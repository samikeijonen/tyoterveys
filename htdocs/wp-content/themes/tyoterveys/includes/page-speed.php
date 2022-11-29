<?php
/**
 * Page speed features.
 *
 * @package Kala
 */

namespace Kala;

/**
 * Delay JS by changing `src=` to `delay=` in GTM and Cookiebot.
 *
 * @link https://blog.speedvitals.com/delay-javascript/
 *
 * @return void
 */
function delay_js( $code, $id ) {
    return str_replace( 'src=', 'delay=', $code );
}
add_filter( 'mtps_gtm_head_code', 'Kala\delay_js', 10, 2 );
add_filter( 'mtps_cookiebot_code', 'Kala\delay_js', 10, 2 );

/**
 * Change `delay` attributes back to `src` attributes.
 *
 * @return void
 */
function print_delay_js() {
    ?>
    <script>
        var delayLoaded = false;
        var autoLoadDuration = 5;
        var eventList = ["keydown", "mousemove", "wheel", "touchmove", "touchstart", "touchend"];

        var autoLoadTimeout = setTimeout(runScripts, autoLoadDuration * 1000);

        eventList.forEach(function(event) {
            window.addEventListener(event, triggerScripts, { passive: true })
        });

        function triggerScripts() {
            runScripts();
            clearTimeout(autoLoadTimeout);
            eventList.forEach(function(event) {
                window.removeEventListener(event, triggerScripts, { passive: true });
            });
        }

        function runScripts() {
            if (!delayLoaded) {
                document.querySelectorAll("script[data-cookieconsent]").forEach(function(scriptTag) {
                    <?php // Create new script tag and replace "delay=" with "src=". ?>
                    var newNode = document.createElement('script');
                    newNode.setAttribute("data-cookieconsent", "ignore");
                    var newContent = scriptTag.textContent.replace("delay=", "src=");
                    newNode.textContent = newContent;
                    scriptTag.parentNode.replaceChild(newNode, scriptTag);
                });

                document.querySelectorAll("script[delay]").forEach(function(scriptTag) {
                    <?php // Replace "delay=" with "src=" attribute. ?>
                    scriptTag.setAttribute("src", scriptTag.getAttribute("delay"));
                });
            }

            delayLoaded = true;
        }
    </script>
    <?php
}
add_action( 'wp_head', 'Kala\print_delay_js' );
