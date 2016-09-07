<?php

use empleadoEstatalBot\newspaperParser;

class cronicacomarParser extends newspaperParser
{
    public function __construct()
    {
        parent::__construct();
    }

    public function parseText($text)
    {
        $this->dom->loadHTML($text);
        $xpath = new DOMXPath($this->dom);

        $html = '<!DOCTYPE html><html><head><title></title></head><body>';
        $html .= '<h1>' . $xpath->query("//*[contains(@class, 'article-title')]")->item(0)->nodeValue . '</h1>';
        $html .= '<h2>' . $xpath->query("//*[contains(@class, 'article-lead')]")->item(0)->nextSibling->nodeValue . '</h2>';

        $html .= $this->dom->saveHTML($xpath->query("//*[contains(@class, 'article-text')]")->item(0));

        $html .= empleadoEstatalConfig::$SIGNATURE;
        $html .= '</body></html>';

        return $html;
    }
}
