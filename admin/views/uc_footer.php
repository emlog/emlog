<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<footer class="py-4">
    <div class="text-center">
        <span>Copyright © <?= date("Y") ?> </span>
    </div>
</footer>
</div>
</div>
</div>
</main>
<?php doAction('adm_footer') ?>
<script src="./views/js/sb-admin-2.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
</body>
</html>

