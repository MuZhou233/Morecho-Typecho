<div class="card card-nav">
    <div class="search">
            <div id="site-search" class="input-group" action="<?php $this->options->siteUrl(); echo 'search/'; ?>">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i data-feather="search"></i></div>
                </div>
                <input type="text" class="form-control" placeholder="搜索">
            </div>
    </div>

    <div class="profile">
        <?php if($this->is('author')): ?>
            <img class="shadow"
                src="<?php echo Typecho_Common::gravatarUrl(get_user($this->_archiveSlug)['mail'], 256, $this->options->commentsAvatarRating, 'mp', $this->request->isSecure()); ?>"
                alt="<?php echo get_user($this->_archiveSlug)['screenName'] ?>">
        <?php elseif($this->user->hasLogin()): ?>
            <img class="shadow"
                src="<?php echo Typecho_Common::gravatarUrl($this->user->mail, 256, $this->options->commentsAvatarRating, 'mp', $this->request->isSecure()); ?>"
                alt="<?php echo $this->options->user->name ?>">
        <?php elseif($this->is('post')): ?>
            <img class="shadow"
                src="<?php echo Typecho_Common::gravatarUrl($this->author->mail, 256, $this->options->commentsAvatarRating, 'mp', $this->request->isSecure()); ?>"
                alt="<?php echo $this->options->user->name ?>">
        <?php elseif($this->options->avatar): ?>
            <img class="shadow" src="<?php $this->options->avatar(); ?>">
        <?php endif ?>
        <?php if($this->is('author')): ?>
        <?php elseif($this->user->hasLogin()): ?>
            <p class="profile-name"><?php echo $this->user->screenName ?></p><p class="profile-title"><?php echo get_user_title() ?></p>
        <?php elseif($this->is('post')): ?>
            <p class="profile-name"><?php $this->author(); ?></p><p class="profile-title">作者</p>
        <?php elseif($this->options->owner): ?>
            <p class="profile-name"><?php $this->options->owner(); ?></p>
        <?php endif ?>
    </div>

    <div class="site-controls text-center align-middle">
        <div class="row">
            <div class="col-4 active" data-tab="navigation"><a href="javascript:;"><i
                        data-feather="compass"></i><br /><span>导航</span></a></div>
            <div class="col-4" data-tab="folder"><a href="javascript:;"><i
                        data-feather="folder"></i><br /><span>归档</span></a></div>
            <div class="col-4" data-tab="setting"><a href="javascript:;"><i
                        data-feather="settings"></i><br /><span>设置</span></a></div>
        </div>
    </div>

    <div class="site-control">
        <div data-tab="navigation" class="active">
            <nav class="nav flex-column nav-pills">
                <a class="nav-link <?php if($this->is('index')): ?>active<?php endif; ?>" href="/">首页</a>
                <?php $this->widget('Widget_Contents_Page_List') -> to($pages); ?>
                <?php while($pages->next()): ?>
                <a class="nav-link <?php echo $this->is('page', $pages->slug)?'active':''; ?>"
                    href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a>
                <?php endwhile; ?>
                <?php if(array_key_exists('MorechoCore', Typecho_Plugin::export()['activated'])): ?>
                    <?php if($this->options->linkAbout != '0'): ?>
                    <a class="nav-link <?php echo $this->is('author', $this->options->linkAbout)?'active':''; ?>"
                        href="/author/<?php echo $this->options->linkAbout; ?>">关于</a>
                    <?php endif; ?>
                    <?php if($this->options->linkFriends != '0'): ?>
                    <a class="nav-link <?php echo $this->is('Morecho_link_page')?'active':''; ?>"
                        href="/link/"><?php echo $this->options->linkFriends; ?></a>
                    <?php endif; ?>
                <?php endif; ?>
            </nav>
        </div>
        <div data-tab="folder">
            <nav class="nav flex-column nav-pills">
                <?php if(array_key_exists('MorechoCore', Typecho_Plugin::export()['activated'])): ?> 
                <a class="nav-link <?php if(Typecho_Router::getPathInfo() == '/archive/')echo 'active' ?>"
                    href="/archive/">全部文章</a>
                <?php endif; ?>
                <?php $this->widget('Widget_Metas_Category_List')->to($categories); ?>
                <?php while($categories->next()): ?>
                <a class="nav-link <?php echo $this->is('category', $categories->slug)?'active':''; ?>"
                    href="<?php $categories->permalink(); ?>"><?php $categories->name(); ?></a>
                <?php endwhile; ?>
            </nav>
        </div>
        <div data-tab="setting">
            <div class="title">主题</div>
            <div class="theme-control row">
                <div class="col">
                    <div class=""></div>
                </div>
                <div class="col">
                    <div class="theme-front-green"></div>
                </div>
                <div class="col">
                    <div class="theme-front-orange"></div>
                </div>
            </div>
            <?php if ($this->user->hasLogin()): ?>
            <div class="title">已登录</div>
            <nav class="nav flex-column nav-pills">
                <?php if($this->user->group == 'administrator'): ?>
                <a class="nav-link" href="<?php $this->options->adminUrl(); ?>"><?php _e('后台管理'); ?></a>
                <?php endif; ?>
                <a class="nav-link active" href="<?php $this->options->profileUrl(); ?>"><?php _e('个人设置'); ?></a>
                <a class="nav-link" href="<?php $this->options->logoutUrl(); ?>"><?php _e('退出'); ?></a>
            </nav>
            <?php else: ?>
            <div class="title">未登录</div>
            <form action="<?php $this->options->loginAction()?>" method="post" name="login" class="login-form"
                rold="form">
                <input type="hidden" name="referer" class="form-control form-control-sm"
                    value="<?php $this->options->siteUrl(); ?>">
                <div class="form-row">
                    <div class="col">
                        <input type="text" name="name" class="form-control form-control-sm" autocomplete="username"
                            placeholder="用户名" required />
                    </div>
                    <div class="col-auto">
                        <a href="<?php echo $this->options->adminUrl.'register.php'; ?>" class="submit btn btn-sm"
                            style="padding-left: 0;padding-right:0"><?php _e('没有账号？'); ?></a>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <input type="password" name="password" class="form-control form-control-sm"
                            autocomplete="current-password" placeholder="密码" required />
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="submit btn btn-sm btn-primary"><?php _e('登录'); ?></button>
                    </div>
                </div>
            </form>
            <?php endif ?>
        </div>
    </div>

    <div style="height:5rem"></div>
</div>