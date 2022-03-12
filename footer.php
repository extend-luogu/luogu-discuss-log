<style>
.jumbotron a {
    color: rgba(255, 255, 255, .75);
    transition: color 0.2s;
}

.jumbotron a:hover {
    color: rgba(255, 255, 255, 1);
}

#lfooter {
    margin-bottom: 0;
    width: 100%;
    padding-top: 20px;
    padding-bottom: 10px;
    background: rgb(91, 165, 197);
    filter: blur(0px) brightness(100%);
    color: #fff;
    box-shadow: 0 0.375rem 1.375rem rgb(175 194 201 / 50%);
    border-radius: 0px;
}
</style>
<div id="lfooter" class="jumbotron">
    <!-- ad you can remove this -->
    <div class="info">
        <p>
            Made by <a href="//www.luogu.com.cn/user/237496">__OwO__</a> and <a
                href="//www.luogu.com.cn/user/37084">Yemaster</a> ,
            <a href="https://github.com/extend-luogu/luogu-discuss-log">Github</a> ;
            Powered By <a href="https://idc.oierbbs.fun">OIerbbs Cloud</a><br />
            已经有了<span id="rownum">...</span>页保存的帖子;
            渲染用时:
            <?php
            /* show time of rendering */
            $end = microtime(true);
            $creationtime = ($end - $start);
            printf("%.6fs", $creationtime);
            ?>
        </p>
        <div display="none"></div>
    </div>
    <!-- get row num  -->
    <script>
    document.title = document.title + " - luogulo"
    $.get('/api.php?totalpage').then(u => $('#rownum').text(u))
    </script>
</div>