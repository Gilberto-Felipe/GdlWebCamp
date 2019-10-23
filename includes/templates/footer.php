<footer class="site-footer">
    <div class="contenedor clearfix">
          <div class="footer-informacion">
               <h3>Sobre <span>gdlwebcamp</span> </h3>
               <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          </div> <!--footer-informacion-->
          <div class="ultimos-tweetts">
               <h3>Últimos <span>tweets</span> </h3>
               <ul>
                    <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt. </li>
                    <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </li>
                    <li>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</li>
               </ul>
          </div><!--últimos tweets-->
          <div class="menu">
               <h3>Redes <span>sociales</span> </h3>
               <nav class="redes-sociales">
                 <a href="#"><i class="fab fa-facebook-f"></i></a>
                 <a href="#"><i class="fab fa-twitter"></i></a>
                 <a href="#"><i class="fab fa-pinterest-p"></i></a>
                 <a href="#"><i class="fab fa-youtube"></i></a>
                 <a href="#"><i class="fab fa-instagram"></i></a>
               </nav>
          </div><!--menu-->
    </div><!--contenedor clearfix-->

    <p class="copyright">Todos los derechos reservados GDLWEBCAMP&copy; 2018</p>

    <!-- Begin Mailchimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
<style type="text/css">
	#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
	/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
</style>
<div style="display:none;">
     <div id="mc_embed_signup">
     <form action="https://ucol.us19.list-manage.com/subscribe/post?u=fac55aab5a47fc9aded3b62b7&amp;id=0c22542baa" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
         <div id="mc_embed_signup_scroll">
     	<h2>Suscríbete a las noticias y no te pierdas nada de este evento</h2>
     <div class="indicates-required"><span class="asterisk">*</span> es obligatorio</div>
     <div class="mc-field-group">
     	<label for="mce-EMAIL">Correo electrónico  <span class="asterisk">*</span>
     </label>
     	<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
     </div>
     	<div id="mce-responses" class="clear">
     		<div class="response" id="mce-error-response" style="display:none"></div>
     		<div class="response" id="mce-success-response" style="display:none"></div>
     	</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
         <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_fac55aab5a47fc9aded3b62b7_0c22542baa" tabindex="-1" value=""></div>
         <div class="clear"><input type="submit" value="Suscribirse" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
         </div>
     </form>
     </div>
     <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[3]='ADDRESS';ftypes[3]='address';fnames[4]='PHONE';ftypes[4]='phone'; /*
      * Translated default messages for the $ validation plugin.
      * Locale: ES
      */
     $.extend($.validator.messages, {
       required: "Este campo es obligatorio.",
       remote: "Por favor, rellena este campo.",
       email: "Por favor, escribe una dirección de correo válida",
       url: "Por favor, escribe una URL válida.",
       date: "Por favor, escribe una fecha válida.",
       dateISO: "Por favor, escribe una fecha (ISO) válida.",
       number: "Por favor, escribe un número entero válido.",
       digits: "Por favor, escribe sólo dígitos.",
       creditcard: "Por favor, escribe un número de tarjeta válido.",
       equalTo: "Por favor, escribe el mismo valor de nuevo.",
       accept: "Por favor, escribe un valor con una extensión aceptada.",
       maxlength: $.validator.format("Por favor, no escribas más de {0} caracteres."),
       minlength: $.validator.format("Por favor, no escribas menos de {0} caracteres."),
       rangelength: $.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
       range: $.validator.format("Por favor, escribe un valor entre {0} y {1}."),
       max: $.validator.format("Por favor, escribe un valor menor o igual a {0}."),
       min: $.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
     });}(jQuery));var $mcj = jQuery.noConflict(true);</script><!--End mc_embed_signup-->
</div>
</footer>

<script src="js/vendor/modernizr-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script>
  window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')
</script>
<script src="js/plugins.js"></script>
<script src="js/jquery.animateNumber.min.js"></script>
<script src="js/jquery.countdown.min.js"></script>
<script src="js/jquery.lettering.js"></script>

<?php
   //Obtenemos el nombre de la pagina actual que se está cargando
   $archivo = basename($_SERVER['PHP_SELF']); // basename — Devuelve el último componente de nombre de una ruta, en este caso .php Estoy pidiendo el archivo de cada página, todos son php
   $pagina = str_replace(".php", "", $archivo); // str_repalce remplazar ("elemnto a cambiar", "remplazo", "origen/var")
   // Cargar plugins js de acuerdo a cada página
   if ($pagina == 'invitados' || $pagina == 'index') {
        echo '<script src="js/jquery.colorbox-min.js"></script>';
   }
   elseif ($pagina == 'conferencia') {
        echo '<script src="js/lightbox.min.js"></script>';
   }
?>

<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
<script src="js/main.js"></script>
<script src="js/cotizador.js"></script>

<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
<script>
  window.ga = function() {
   ga.q.push(arguments)
  };
  ga.q = [];
  ga.l = +new Date;
  ga('create', 'UA-XXXXX-Y', 'auto');
  ga('send', 'pageview')
</script>
<script src="https://www.google-analytics.com/analytics.js" async defer></script>
<script type="text/javascript" src="//downloads.mailchimp.com/js/signup-forms/popup/unique-methods/embed.js" data-dojo-config="usePlainJson: true, isDebug: false"></script><script type="text/javascript">window.dojoRequire(["mojo/signup-forms/Loader"], function(L) { L.start({"baseUrl":"mc.us19.list-manage.com","uuid":"fac55aab5a47fc9aded3b62b7","lid":"0c22542baa","uniqueMethods":true}) })</script>
</body>
</html>
