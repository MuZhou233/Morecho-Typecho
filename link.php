<?php
/**
 * link
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$db = Typecho_Db::get();
$users = $db->fetchALL($db->select('name','screenName','url','mail','group','introduction')->from('table.users')->where('url <> ?', ''));

function linkCard($user, $avatarRating){
    $url = $user['url'];
    $name = $user['screenName'];
    $intro = $user['introduction'];
    $avatar = 'https://secure.gravatar.com/avatar/'.md5(strtolower($user['mail'])).'?s=144&r='.$avatarRating.'&d=mp';
    echo '
    <a href="'.$url.'">
        <blockquote class="card-meta">
            <span>
                <p>'.$name.'</p>
                <p>'.$intro.'</p>
            </span>
            <span class="card-meta-background"
                style="background-image:url('.$avatar.')">
            </span>
            <span>
                <img src="'.$avatar.'">
            </span>
        </blockquote>
    </a>
    ';
}

$this->need('_layouts/default-0.php'); ?>

<article class="card-link">
<?php 
$options = Typecho_Widget::widget('Widget_Options')->plugin('MorechoFriends');
$group = array('administrator', 'editor', 'contributor', 'subscriber');
$groupName = array($options->groupTitleA, $options->groupTitleE, $options->groupTitleC, $options->groupTitleS);
for ($i = 0; $i < 4; $i++) if (!empty($groupName[$i])) foreach ($users as $user) if ($user['group'] === $group[$i]) {
    echo '<h3>'.$groupName[$i].'</h3>';
    foreach ($users as $user)if ($user['group'] === $group[$i]) {
        if (empty($user['screenName'])) $user['screenName'] = $user['name'];
        $user['introduction'] = Typecho_Common::subStr(Typecho_Common::stripTags(Widget_Abstract_Contents::markdown($user['introduction'])), 0, 14, '...');
        linkCard($user, $this->options->commentsAvatarRating);
    }
    break;
}
?>
</article>

<style>
.card-link{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    align-items: center;
    margin-top: 5rem;
    padding: 0;
}
.card-link h3{
    width: 100%;
}
.card-link h3:before{
    display: none;
}
.card-link > a{
    padding: 0 .25rem;
}
.card-link blockquote.card-meta{
    height: 65px;
    transition: all .3s ease 0s;
    box-shadow: 0 0.25rem .5rem rgba(0, 0, 0, 0.1);
}
.card-link blockquote.card-meta:hover{
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}
.card-link blockquote.card-meta p,
.card-link blockquote.card-meta a {
    color: rgba(0,0,0,.7);
    font-size: .6rem;
    font-weight: bold;
}
.card-link blockquote.card-meta p:first-child{
    font-size: 1rem;
}
.card-link blockquote.card-meta span:last-child{
    max-width: unset !important;
    width: 65px;
}
@media (max-width: 767px) {
    .card-link > a{
        width: 100%;
    }
}
</style>

<?php $this->need('_layouts/default-1.php'); ?>