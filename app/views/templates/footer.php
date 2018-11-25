<?php if ( ! defined('BASE_URL')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 24-11-2018
 * Time: 23:54
 */
// CSRF token
echo $token;
;?>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->


<script src="<?php echo site_url('/public/js/javascript.js');?>"></script>

<?php echo isset($scripts) ? $scripts : '' ;?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>

