<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
</div>
</div>
</div>
</main>
<footer class="py-3">
    <div class="text-center">
        <small>© <?= date("Y") ?> <?= Option::get('blogname') ?> </small>
    </div>
</footer>
<?php doAction('adm_footer') ?>
</body>

</html>