<script type="text/javascript">
  var javascriptVersion = 1.0;
</script>
<script language="Javascript1.1">
  javascriptVersion = 1.1;
</script>
<script language="Javascript1.2">
  javascriptVersion = 1.2;
</script>
<script language="Javascript1.3">
  javascriptVersion = 1.3;
</script>
<script language="Javascript1.4">
  javascriptVersion = 1.4;
</script>
<script language="Javascript1.5">
  javascriptVersion = 1.5;
</script>
<script language="Javascript1.6">
  javascriptVersion = 1.6;
</script>
<script language="Javascript1.7">
  javascriptVersion = 1.7;
</script>
<script language="Javascript1.8">
  javascriptVersion = 1.8;
</script>
<script language="Javascript1.9">
  javascriptVersion = 1.9;
</script>

<script type="text/javascript">

    function navigatorVersion(){
        var ua= navigator.userAgent, tem,
        M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
        if(/trident/i.test(M[1])){
            tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
            return 'IE '+(tem[1] || '');
        }
        if(M[1]=== 'Chrome'){
            tem= ua.match(/\bOPR\/(\d+)/);
            if(tem!= null) return 'Opera '+tem[1];
        }
        M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
        if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
        return M.join(' ');
    };
    alert(javascriptVersion);
    alert(navigatorVersion())
</script>


<?= $this->Html->script('LogPluginColetores.core/verify-support' . $aRemoveCache['js']); ?>
