/**
 * Author: Silvio Regis 
 * 
 * Utilizar a classe monaco-editor-init para aplicar o editor
 * e carregar o script 'Plugins/MonacoEditor/loader' onde for utilizar o editor:
 * 
 * 
    <?= $this->Html->script([
        'Plugins/MonacoEditor/loader'
    ]) ?>
 * 
 * html exemple:
 * 
  <div class="col-lg-10 monaco-editor-init">
      <?= $this->Form->textarea('monaco-editor-code', [
          'class' => 'form-control hide monaco-editor-code'
      ]);?>
      <div class="monaco-editor-container" language='sql'></div>
  </div>
 *
 * init:
 * 
  $(window).load(function() {
      MonacoEditorManager.init()
  })
 * 
 */

var MonacoEditorManager = {
    init: function() {
        this.applyListeners()
    },
    applyListeners: function() {
        $('.monaco-editor-init').each(function() {
            $(this).find('.monaco-editor-container').css({
                width: '100%',
                height: 600,
                margin: 0,
                padding: 0,
                overflow: 'hidden'
            })
            var editorContainer = $(this).find('.monaco-editor-container')[0];
            var textarea   = $(this).find('.monaco-editor-code')[0];
            var HTML_CODE  = [$(this).find('.monaco-editor-code')[0].value].join('\n');

            require.config({ paths: { 'vs': 'https://cdn.jsdelivr.net/npm/monaco-editor/min/vs' }});

            window.MonacoEnvironment = {
                getWorkerUrl: () => proxy
            };

            let proxy = URL.createObjectURL(new Blob([`
                self.MonacoEnvironment = {
                    baseUrl: 'https://cdn.jsdelivr.net/npm/monaco-editor/min/'
                };
                importScripts('https://cdn.jsdelivr.net/npm/monaco-editor/min/vs/base/worker/workerMain.js');
            `], {
                type: 'text/sql'
            }));

            require(["vs/editor/editor.main"], function () {
                createEditor(editorContainer);
            });

            function createEditor(editorContainer) {
                var sLang = $(editorContainer).attr('language') 
                    ? $(editorContainer).attr('language') 
                    : 'sql'
                let editor = monaco.editor.create(editorContainer, {
                    value: HTML_CODE,
                    language: sLang,
                    theme: 'vs-dark',
                    // minimap: { enabled: false },
                    automaticLayout: true,
                    contextmenu: false,
                    scrollBeyondLastLine: false,
                    fontSize: 13,
                    // scrollbar: {
                    //     useShadows: false,
                    //     vertical: "visible",
                    //     horizontal: "visible",
                    //     horizontalScrollbarSize: 18,
                    //     verticalScrollbarSize: 18
                    // }
                });
                editor.onDidChangeModelContent(() => {
                    textarea.value = editor.getValue();
                });
            }
        })
    }

}