<?php

#
#
# ParsedownExtend
#
# (c) Tabing & MuZhou233
# https://gyx.moe
#
#

require_once dirname(__FILE__) . '/Parsedown.php';
require_once dirname(__FILE__) . '/ParsedownExtra.php';

class ParsedownExtend extends ParsedownExtra {
    
    function __construct()
    {
        parent::__construct();
        
        $this->InlineTypes['['][] = 'Kbd';
        $this->inlineMarkerList .= '[';
        $this->InlineTypes['@'][] = 'At';
        $this->inlineMarkerList .= '@';
        $this->BlockTypes['?'] []= 'Quote';
        $this->BlockTypes['!'] []= 'Quote';
    }

    #
    # Header

    protected function blockHeader($Line)
    {
        if (isset($Line['text'][1]))
        {
            $level = 1;

            while (isset($Line['text'][$level]) and $Line['text'][$level] === '#')
            {
                $level ++;
            }

            if ($level > 6)
            {
                return;
            }

            $text = trim($Line['text'], '# ');

            $Block = array(
                'element' => array(
                    'name' => 'h' . min(6, $level),
                    'attributes' => array(
                        'id' => str_replace(' ', '-', $text),
                    ),
                    'text' => $text,
                    'handler' => 'line',
                ),
            );

            return $Block;
        }
    }

    protected function inlineCode($Excerpt) {
        $marker = $Excerpt['text'][0];

        if (preg_match('/^('.$marker.'+)[ ]*(.+?)[ ]*(?<!'.$marker.')\1(?!'.$marker.')/s', $Excerpt['text'], $matches)) {
            $text = $matches[2];
            $text = preg_replace("/[ ]*\n/", ' ', $text);

            if($text[0]=='[' && $text[strlen($text)-1]==']') {
                $text = substr($text, 1, -1);
                return array(
                    'extent' => strlen($matches[0]),
                    'element' => array(
                        'name' => 'code',
                        'attributes' => array(
                            'class' => "cover",
                        ),
                        'text' => $text,
                    ),
                );
            } else {
                return array(
                    'extent' => strlen($matches[0]),
                    'element' => array(
                        'name' => 'code',
                        'text' => $text,
                    ),
                );
            }
        };
    }

    protected function inlineKbd($Excerpt)
    {
        if (preg_match('/^(?<!\[)(?:\[\[([^\[\]]*|[\[\]])\]\])(?!\])/s', $Excerpt['text'], $matches)) {
            return array(
                'extent' => strlen($matches[0]),
                'element' => array(
                    'name' => 'kbd',
                    'text' => $matches[1]
                ),

            );
        }
    }

    protected function inlineEmphasis($Excerpt)
    {
        if ( ! isset($Excerpt['text'][1]))
        {
            return;
        }

        $marker = $Excerpt['text'][0];
        
        if($marker === '_')
        {
            return;
        }

        if ($Excerpt['text'][1] === $marker and preg_match($this->StrongRegex[$marker], $Excerpt['text'], $matches))
        {
            $emphasis = 'strong';
        }
        elseif (preg_match($this->EmRegex[$marker], $Excerpt['text'], $matches))
        {
            $emphasis = 'em';
        }
        else
        {
            return;
        }

        return array(
            'extent' => strlen($matches[0]),
            'element' => array(
                'name' => $emphasis,
                'handler' => 'line',
                'text' => $matches[1],
            ),
        );
    }

    private function searchUser($name){
        $options = Helper::options();
        $db = Typecho_Db::get();
        $profile = $db->fetchRow($db->select('uid', 'name', 'screenName')->from('table.users')->where('name=? OR screenName=?', $name, $name));
        if(sizeof($profile) == 0) return false;
        return $profile['uid'];
    }

    protected function inlineAt($Excerpt)
    {
        if (preg_match('/^@([^\s]{1,30})\s/s', $Excerpt['text'], $matches)) {
            $uid = $this->searchUser($matches[1]);
            if($uid)
                return array(
                    'extent' => strlen($matches[0]),
                    'element' => array(
                        'name' => 'a',
                        'text' => '@'.$matches[1],
                        'attributes' => array(
                            'href' => '/author/'.$uid,
                        )
                    )
                );
        }
    }

    private function lazyLoad(){
        return Typecho_Widget::widget('Widget_Options')->plugin('MorechoCore')->lazyload === '1';
    }

    protected function inlineImage($Excerpt)
    {
        if ( ! isset($Excerpt['text'][1]) or $Excerpt['text'][1] !== '[')
        {
            return;
        }

        $Excerpt['text']= substr($Excerpt['text'], 1);

        $Link = $this->inlineLink($Excerpt);

        if ($Link === null)
        {
            return;
        }

        if($this->lazyload())
        $Inline = array(
            'extent' => $Link['extent'] + 1,
            'element' => array(
                'name' => 'img',
                'attributes' => array(
                    'data-src' => $Link['element']['attributes']['href'],
                    'alt' => $Link['element']['text'],
                    'class' => "lazy"
                ),
            ),
        );
        else
        $Inline = array(
            'extent' => $Link['extent'] + 1,
            'element' => array(
                'name' => 'img',
                'attributes' => array(
                    'src' => $Link['element']['attributes']['href'],
                    'alt' => $Link['element']['text'],
                ),
            ),
        );

        $Inline['element']['attributes'] += $Link['element']['attributes'];

        unset($Inline['element']['attributes']['href']);

        return $Inline;
    }

    protected function blockList($Line)
    {
        list($name, $pattern) = $Line['text'][0] <= '-' ? array('ul', '[*+-]') : array('ol', '[0-9]+[.]');

        if (preg_match('/^('.$pattern.'[ ]+)(.*)/', $Line['text'], $matches))
        {
            $Block = array(
                'indent' => $Line['indent'],
                'pattern' => $pattern,
                'element' => array(
                    'name' => $name,
                    'handler' => 'elements',
                ),
            );

            if($name === 'ol')
            {
                $listStart = stristr($matches[0], '.', true);

                if($listStart !== '1')
                {
                    $Block['element']['attributes'] = array('start' => $listStart);
                }
            }

            $Block['li'] = array(
                'name' => 'li',
                'handler' => 'li',
                'text' => array(
                    $matches[2],
                ),
            );

            $text = & $Block['li']['text'][0];
            if($text[0] == '[' && $text[2] == ']' && $text[3] == ' '){
                if($text[1] == ' ') $text = '<input type="checkbox" class="task-list-item-checkbox" disabled="disabled" />' . substr($text, 3);
                else $text = '<input type="checkbox" class="task-list-item-checkbox" disabled="disabled" checked="checked" />' . substr($text, 3);

                $Block['li']['attributes'] = array(
                    'class' => "task-list-item custom-checkbox",
                );
                $Block['element']['attributes'] = array(
                    'class' => "task-list",
                );
            }

            $Block['element']['text'] []= & $Block['li'];

            return $Block;
        }
    }

    protected function blockListContinue($Line, array $Block) {
        if ($Block['indent'] === $Line['indent'] and preg_match('/^'.$Block['pattern'].'(?:[ ]+(.*)|$)/', $Line['text'], $matches)) {
            if (isset($Block['interrupted'])) {
                $Block['li']['text'] []= '';

                $Block['loose'] = true;

                unset($Block['interrupted']);
            }

            unset($Block['li']);

            $text = isset($matches[1]) ? $matches[1] : '';

            if($text[0]=='[' && $text[2]==']' && $text[3]==' ') {

                if($text[1] == ' ') $text = '<input type="checkbox" class="task-list-item-checkbox" disabled="disabled" />' . substr($text, 3);
                else $text = '<input type="checkbox" class="task-list-item-checkbox" disabled="disabled" checked="checked" />' . substr($text, 3);
                
                $Block['li'] = array(
                    'name' => 'li',
                    'handler' => 'li',
                    'attributes' => array(
                        'class' => "task-list-item custom-checkbox",
                    ),
                    'text' => array(
                        $text,
                    ),
                );
            } else {
                $Block['li'] = array(
                    'name' => 'li',
                    'handler' => 'li',
                    'text' => array(
                        $text,
                    ),
                );
            }

            $Block['element']['text'] []= & $Block['li'];

            return $Block;
        }

        if ($Line['text'][0] === '[' and $this->blockReference($Line)) {
            return $Block;
        }

        if ( ! isset($Block['interrupted'])) {
            $text = preg_replace('/^[ ]{0,4}/', '', $Line['body']);

            $Block['li']['text'] []= $text;

            return $Block;
        }

        if ($Line['indent'] > 0) {
            $Block['li']['text'] []= '';

            $text = preg_replace('/^[ ]{0,4}/', '', $Line['body']);

            $Block['li']['text'] []= $text;

            unset($Block['interrupted']);

            return $Block;
        }
    }
    
    #
    # Quote

    protected function blockQuote($Line)
    {
        if (preg_match('/^([!?])?>[ ]?(.*)/', $Line['text'], $matches))
        {
            $class = '';
            $matches2 = trim($matches[2]);
            
            if($matches2[0] === '!') { $class = 'warning'; $matches2 = substr($matches2, 1);}
            if($matches2[0] === '?') { $class = 'info'; $matches2 = substr($matches2, 1);}
            
            $Block = array(
                'element' => array(
                    'name' => 'blockquote',
                    'handler' => 'lines',
                    'text' => (array) $matches2,
                    'attributes' => array(
                        'class' => $class,
                    )
                ),
            );
            if($matches2[0] === '[' && $matches2[1] === ']' && $matches2[2] === '(' && $matches2[-1] === ')')
                $Block = array(
                    'element' => array(
                        'name' => 'blockquote',
                        'handler' => 'lines',
                        'text' => array($this->line('!'.$matches2)),
                        'attributes' => array(
                            'class' => 'card-meta',
                        )
                    ),
                );
            return $Block;
        }
    }

    protected function blockQuoteContinue($Line, array $Block)
    {
        if (preg_match('/^[!?]?>[ ]?(.*)/', $Line['text'], $matches))
        {
            if (isset($Block['interrupted']))
            {
                $Block['element']['text'] []= '';
                unset($Block['interrupted']);
            }
            $Block['element']['text'] []= $matches[1];
            return $Block;
        }

        if ( ! isset($Block['interrupted']))
        {
            $Block['element']['text'] []= $Line['text'];
            return $Block;
        }
    }

    #
    # Fenced Code

    protected function blockFencedCode($Line)
    {
        if (preg_match('/^['.$Line['text'][0].']{3,}[ ]*([^`]+)?[ ]*$/', $Line['text'], $matches))
        {
            $Element = array(
                'name' => 'code',
                'text' => '',
            );

            if (isset($matches[1]))
            {
                /**
                 * https://www.w3.org/TR/2011/WD-html5-20110525/elements.html#classes
                 * Every HTML element may have a class attribute specified.
                 * The attribute, if specified, must have a value that is a set
                 * of space-separated tokens representing the various classes
                 * that the element belongs to.
                 * [...]
                 * The space characters, for the purposes of this specification,
                 * are U+0020 SPACE, U+0009 CHARACTER TABULATION (tab),
                 * U+000A LINE FEED (LF), U+000C FORM FEED (FF), and
                 * U+000D CARRIAGE RETURN (CR).
                 */
                $language = substr($matches[1], 0, strcspn($matches[1], " \t\n\f\r"));

                if(is_numeric($language))
                    $Element['attributes'] = array(
                        'data-startnum' => $language,
                    );
                else
                    $Element['attributes'] = array(
                        'data-language' => $language,
                    );
            }

            $Block = array(
                'char' => $Line['text'][0],
                'element' => array(
                    'name' => 'pre',
                    'handler' => 'element',
                    'text' => $Element,
                ),
            );

            return $Block;
        }
    }
}
