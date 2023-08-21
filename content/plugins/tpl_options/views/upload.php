<?php
!defined('EMLOG_ROOT') && exit('access deined!');
?>
<script>
    parent.setImage('<?php echo $src; ?>', '<?php echo $path; ?>', <?php echo $code; ?>, '<?php echo $this->encode($msg); ?>');
</script>