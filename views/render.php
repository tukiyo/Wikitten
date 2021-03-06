<div class="breadcrumbs">
    <?php if ($html && isset($source)): ?>
        <div class="pull-right">
            <a href="#" class="btn btn-mini btn-inverse" id="toggle" accesskey="t">(T)oggle source</a>
        </div>
    <?php endif ?>

    <?php $path = array(); ?>
    <ul class="unstyled">
        <li>
            <a href="<?php echo BASE_URL; ?>"><i class="icon-home icon-white"></i> /wiki</a>
        </li>
        <?php $i = 0; ?>

        <?php foreach ($parts as $part): ?>
            <?php $path[] = $part; ?>
            <?php $url = BASE_URL . "/" . join("/", $path) ?>
            <li>
                <a href="<?php echo htmlspecialchars($url, ENT_QUOTES, 'UTF-8') ?>">
                    <?php if (++$i == count($parts) && !$is_dir): ?>
                        <i class="icon-file icon-white"></i>
                    <?php else: ?>
                        <i class="icon-folder-open icon-white"></i>
                    <?php endif ?>
                    <?php echo $part; ?>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
    <div class="clear"></div>
</div>

<?php if ($html): ?>
    <div id="render">
        <?php echo $html; ?>
    </div>
    <script>
        $('#render pre').addClass('prettyprint linenums');
        prettyPrint();

        $('#render a[href^="#"]').click(function(event) {
            event.preventDefault();
            document.location.hash = $(this).attr('href').replace('#', '');
        });
    </script>
<?php endif ?>

<?php if (isset($source)): ?>
    <div id="source">
        <?php if (ENABLE_EDITING): ?>
            <div class="alert alert-info">
                <i class="icon-pencil"></i> <strong>Editing is enabled</strong>. Use the "Save changes" button below the editor to commit modifications to this file.
            </div>
        <?php endif ?>

        <form method="POST" action="<?php echo BASE_URL . "/?a=edit" ?>">
            <input type="hidden" name="ref" value="<?php echo base64_encode($page['file']) ?>">
            <textarea id="editor" name="source" class="input-block-level" rows="<?php echo substr_count($source, "\n") + 1; ?>"><?php echo $source; ?></textarea>

            <?php if (ENABLE_EDITING): ?>
                <div class="form-actions">
                    <input type="submit" class="btn btn-inverse" value="(S)ave Changes" accesskey="s">
                </div>
            <?php endif ?>
        </form>
    </div>

    <script>
        <?php if ($html): ?>
            CodeMirror.defineInitHook(function () {
                $('#source').hide();
            });
        <?php endif ?>

        var mode = false;
        var modes = {
            'md': 'markdown',
            'js': 'javascript',
            'php': 'php',
            'sql': 'text/x-sql',
            'py': 'python',
            'clj': 'clojure',
            'rb': 'ruby',
            'css': 'css',
            'hs': 'haskell',
            'lsh': 'haskell',
            'pl': 'perl',
            'r': 'r',
            'scss': 'sass',
            'sh': 'shell',
            'xml': 'xml',
            'html': 'htmlmixed',
            'htm': 'htmlmixed'
        };
        var extension = '<?php echo $extension ?>';
        if (typeof modes[extension] != 'undefined') {
            mode = modes[extension];
        }

        var editor = $('#editor');
        editor.prop('data-editor', CodeMirror.fromTextArea(editor[0], {
            mode: mode,
            theme: 'default',
            lineNumbers: true,
            lineWrapping: true
            <?php if(!ENABLE_EDITING): ?>
                ,readOnly: true
            <?php endif ?>
        }));

        $('#toggle').on('click', function (event) {
            event.preventDefault();

            var source = $('#source');
            var render = $('#render');
            var submit = $('#submit-edit');

            source.toggle();
            render.toggle();

            if (source.is(':visible')) {
                $('#editor').prop('data-editor').refresh();
            }
        });
    </script>
<?php endif ?>
