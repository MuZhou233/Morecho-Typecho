<?php

#
#
# ParsedownExtend
#
# (c) Tabing
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
            if($matches[1] === '!') $class = 'info';
            if($matches[1] === '?') $class = 'warning';
            
            $Block = array(
                'element' => array(
                    'name' => 'blockquote',
                    'handler' => 'lines',
                    'text' => (array) $matches[2],
                    'attributes' => array(
                        'class' => $class,
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
}
