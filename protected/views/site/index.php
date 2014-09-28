<div class="page-header">
    <fieldset>
        <legend>发布系统要求</legend>
        <ul>
            <li>
                PHP扩展
                <ul>
                    <li>svn（windows 不支持）</li>
                    <li>ssh2</li>
                    <li>服务器上安装了rsync</li>
                </ul>
            </li>
            <li>服务器上安装了rsync</li>
            <li>可以访问所有的线上服务器</li>
        </ul>
    </fieldset>
    <fieldset>
        <legend>应用服务器的要求</legend>
        <ul>
            <li>nginx的主配置文件的http段，需要有“include redstar/*.conf”</li>
            <li>其他需求在添加服务器的时候有提示</li>
        </ul>
    </fieldset>
</div>