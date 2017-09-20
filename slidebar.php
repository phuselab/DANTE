        
        <?php 
            $start_lbl = ($_GET['type'] == "arousal") ? 'Very Passive' : 'Very Negative';
            $end_lbl   = ($_GET['type'] == "arousal") ? 'Very Active' : 'Very Positive';
        ?>

        <input onblur="this.focus()" autofocus id="slider" data-slider-id='annoSlider' type="text" data-slider-min="-1" data-slider-max="1" data-slider-step="0.001" data-slider-value="0" data-slider-ticks="[-1, 0, 1]"
        data-slider-ticks-labels='["<b><?php echo $start_lbl ?></b>", "0", "<b><?php echo $end_lbl ?></b>"]'/>

        <!--carico immagine del sam in base al tipo di video-->
        <div class="sam">
                <?php 
                if($_GET['type'] == "arousal"){
                    echo '<img class="samimg" src="img/samarousal.png"/>';
                }else if($_GET['type'] == "valence"){
                    echo '<img class="samimg" src="img/samvalence.png"/>';
                }
                ?>
        </div>

        <script>

            //valSlidebar è il valore tra -1 e 1 assunta dalla slide bar
/*            var valSlidebar = 0;
            
            var bar = document.getElementById('bar');
            var slider = document.getElementById('slider');
            //halfWidthSlider rappresenta metà della larghezza dello slider
            var halfWidthSlider = slider.offsetWidth/2;
            //Flag per identificare se lo slider è attivo (segue il mouse) o disattivo
            var activate = false;
            
            //coordinata x dell'inizio e fine della barra bar
            var xiBar = bar.offsetLeft-halfWidthSlider;
            var xfBar = bar.offsetLeft+bar.offsetWidth-slider.offsetWidth+halfWidthSlider;
            
            //centro limmagine dello slider in mezzo alla barra
            slider.style.left = xiBar+2+(xfBar-xiBar)/2+'px';
            
            function switchActivate() {
                activate = !activate;
            }
            
            //Funzione che fa raggiungere il puntatore del mouse allo slider
            //Assegna alla variabile valSlidebar il valore -1:1 della nuova posizione assunta 
            function follow(event){
                if(activate){
                    //alle coordinate del mouse e tolgo 20 (metà larghezzaslider), in modo che il cursore sia al centro
                    var x = event.clientX-halfWidthSlider; 
                    if(x>xiBar && x<xfBar){
                        slider.style.left = x+'px';
                        valSlidebar= getValSlidebar(x, xiBar, xfBar);
                    }else if (x<=xiBar){
                        slider.style.left = xiBar+'px';
                        valSlidebar = -1;
                    }else if (x>=xfBar) {
                        slider.style.left = xfBar+'px';
                        valSlidebar= 1;
                    }
                }
            }
            
            //data la posizione x dello slider, del punto x iniziale e finale della barra 
            //restituisce un valore scalato su -1:1
            function getValSlidebar(xSlider, xiBar, xfBar){
                var percentuale = ((xSlider-xiBar)/(xfBar-xiBar));
                var ris = percentuale * 2 - 1;
                return ris;
            }*/

        </script>
    </body>
</html>