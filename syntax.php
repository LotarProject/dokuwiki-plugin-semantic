<?php
/**
 * Semantic plugin: Add Schema.org News Article using JSON-LD
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 */
// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

class syntax_plugin_semantic extends DokuWiki_Syntax_Plugin {

    function getType() { return 'substition'; }
    function getSort() { return 99; }

    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('~~NewsArticle~~', $mode, 'plugin_semantic');
        $this->Lexer->addSpecialPattern('~~Article~~',     $mode, 'plugin_semantic');
        $this->Lexer->addSpecialPattern('~~TechArticle~~', $mode, 'plugin_semantic');
        $this->Lexer->addSpecialPattern('~~BlogPosting~~', $mode, 'plugin_semantic');
        $this->Lexer->addSpecialPattern('~~NOSEMANTIC~~', $mode, 'plugin_semantic');
    }

    function handle($match, $state, $pos, Doku_Handler $handler) {
        return array($match, $state, $pos);
    }

    function render($mode, Doku_Renderer $renderer, $data) {

        if ($mode == 'xthml') {
            return true; // don't output anything
        } elseif ($mode == 'metadata') {

            list($match, $state, $pos) = $data;

            if ($match == '~~NOSEMANTIC~~') {
                $renderer->meta['semantic']['enabled'] = false;
            } else {
                $renderer->meta['semantic']['schema.org']['type'] = trim(str_replace('Schema.org/', '', $match), '~~');
                $renderer->meta['semantic']['enabled'] = true;
            }

        }
    }

}
