<div class="jumbotron" style="margin-bottom:0; width:100%; padding-top: 20px; padding-bottom: 10px;">
    <!-- ad you can remove this -->
    <p>
        Made by <a href="//www.luogu.com.cn/user/237496">__OwO__</a> , Hosted by <a href="//idc.oierbbs.fun">OIerBBS</a>
        , <a href="https://github.com/extend-luogu/luogu-discuss-log">Github</a>
    </p>
    <p>已经有了<text id="rownum">...</text>页保存的帖子</p>
    <p>渲染用时:
        <?php
        /* show time of rendering */
        $end = microtime(true);
        $creationtime = ($end - $start);
        printf(" %.6fs", $creationtime);
        ?>
    </p>
    <!-- get row num  -->
    <script>
        $.get('/rownum.php').then(u => $('#rownum').text(u))
    </script>
</div>