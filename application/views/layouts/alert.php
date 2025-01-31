<?php defined('BASEPATH') or exit('No direct script access allowed');

$alert = $this->session->userdata("alert");

if ($alert) {
    if ($alert["type"] === "success") { ?>
        <script>
            swal('<?php echo $alert["title"]; ?>', '<?php echo $alert["text"]; ?>', 'success');
        </script>
    <?php } else { ?>
        <script>
            swal('<?php echo $alert["title"]; ?>', '<?php echo $alert["text"]; ?>', 'warning');
        </script>
<?php }
} ?>