<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function threadedComments($comments, $options)
{
  $commentClass = '';
  if ($comments->authorId) {
    if ($comments->authorId == $comments->ownerId) {
      $commentClass .= ' comment-by-author';
    } else {
      $commentClass .= ' comment-by-user';
    }
  }
  $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
  ?>
<li class="comment-list-item<?php
  if ($comments->levels > 0) {
    echo ' comment-child';
  } else {
    echo ' comment-parent';
  }
  echo $commentClass;
  ?>">
    <div id="<?php $comments->theId(); ?>" class="comment-body">
        <div class="comment-meta">
            <div class="comment-author">
              <?php if ($comments->url): ?>
                <a href="<?php echo $comments->url ?>" target="_blank"' . ' rel="external nofollow">
              <?php endif; ?>
              <?php $comments->gravatar('64', 'mp'); echo $comments->author; ?>
              <?php $title = get_user_title($comments->author); if(strlen($title)>0): ?>
              <span class="comment-author-title"><?php echo $title ?></span>
              <?php endif; ?>
              <?php if ($comments->url): ?>
                </a>
              <?php endif; ?>
            </div>
            <div class="comment-time"><?php $comments->date('y-m-d'); ?></div>
            <?php $comments->content(); ?>
            <div class="comment-reply"><?php $comments->reply('<i data-feather="message-square"></i> 回复') ?></div>
        </div>
        <hr />
    </div>
    <?php if ($comments->children): ?>
    <div class="comment-children"><?php $comments->threadedComments($options); ?></div>
    <?php endif; ?>
</li>
<?php } ?>

<div class="card card-comments">
    <?php 
      $this->comments()->to($comments); 
    ?>
    <h1 id="comments">评论区</h1>
    <hr />

    <?php if ($comments->have()): ?>
    <h2 id="comment-num"><?php $this->commentsNum(_t('暂无评论'), _t('1 条评论'), _t('%d 条评论')); ?></h2>

    <?php $comments->listComments(); ?>

    <?php
        $comments->pageNav('<span class="backward"><i data-feather="chevrons-left"></i></span>', '<span class="forward"><i data-feather="chevrons-right"></i></span>', 3, '...', array(
            'wrapTag' => 'ul', 
            'wrapClass' => 'pagination justify-content-center', 
            'itemTag' => 'li', 
            'itemClass' => 'page-item',
            'linkClass' => 'page-link',
            'currentClass' => 'active'
        ));
    ?>

    <?php endif; ?>

    <?php if($this->allow('comment')): ?>
    <div id="<?php $this->respondId(); ?>" class="comment-respond">
        <h2 id="add-comment" style="display: none"><?php _e('添加新评论'); ?></h2>
        <form method="post" action="<?php $this->commentUrl() ?>" class="comment-form" role="form">
            <?php if($this->user->hasLogin()): ?>
            <div class="comment-respond-author">
              <a href="<?php $this->options->profileUrl(); ?>" target="_blank" rel="external nofollow">
                <img class="avatar shadow" src="https://secure.gravatar.com/avatar/<?php echo md5(strtolower($this->user->mail)) ?>?s=80&r=<?php echo $this->options->commentsAvatarRating ?>&d=mp" alt="<?php echo $this->options->user->name ?>">
                <?php echo $this->user->screenName ?>
              </a>
              <span>添加回复</span>
            </div>
            <?php else: ?>
            <div class="comment-respond-author">
              <img class="avatar shadow" src="https://secure.gravatar.com/avatar?s=80&r=<?php echo $this->options->commentsAvatarRating ?>&d=mp">
              <div class="form-row">
                  <div class="col-6 col-md-4">
                    <input type="text" name="author" class="form-control form-control-sm" 
                        value="<?php $this->remember('author'); ?>" placeholder="称呼" required />
                  </div>
                  <div class="col-6 col-md-4">
                    <input type="text" name="url" class="form-control form-control-sm" 
                        value="<?php $this->remember('url'); ?>" placeholder="http://" 
                        <?php if ($this->options->commentsRequireURL): ?> class="required"<?php endif; ?> />
                  </div>
                  <div class="col">
                    <input type="text" name="mail" class="form-control form-control-sm" 
                        value="<?php $this->remember('mail'); ?>" placeholder="Email" 
                        <?php if ($this->options->commentsRequireMail): ?> class="required"<?php endif; ?> />
                  </div>
              </div>
            </div>
            <?php endif; ?>
            <div class="form-row">
                <div class="col">
                    <textarea type="text" class="form-control form-control-sm" rows="1" name="text" id="textarea" required><?php $this->remember('text'); ?></textarea>
                </div>
                <div class="col-auto">
                    <button type="submit" class="submit btn btn-sm btn-primary"><?php _e('提交'); ?></button>
                </div>
            </div>
            <div class="comment-reply-cancel">
                <?php $comments->cancelReply('<i data-feather="message-square"></i> 取消'); ?>
            </div>
            <hr/>
        </form>
    </div>
    <?php else: ?>
    <h2 id="comment-closed"><?php _e('评论功能已关闭'); ?></h2>
    <?php endif; ?>
</div>