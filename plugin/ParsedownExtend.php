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

class ParsedownExtend extends Parsedown {
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
}
