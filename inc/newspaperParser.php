<?php

class newspaperParser
{
    protected $newspaper;

    public function __construct($adapter)
    {
        if (class_exists($adapter . 'Parser')) {
            $this->newspaper = $adapter . 'Parser';
        } else {
            throw new BadFunctionCallException;
        }
    }

    public function parse($text)
    {
        $parser = new $this->newspaper();
        return $parser->parseText($text);
    }
}

interface NewspaperInterface
{
    public function parseText($text);
}

class lanacioncomarParser extends newspaperParser
{
    protected $dom;

    public function __construct()
    {
        $this->dom = new DOMDocument();
        //libxml_use_internal_errors(true);
    }

    public function parseText($text)
    {
        $this->dom->loadHTML(mb_convert_encoding($text, 'HTML-ENTITIES', "UTF-8"));
        $xpath = new DOMXPath($this->dom);

        $titulo = $xpath->query("//*[@itemprop='headline']")->item(0)->nodeValue;
        $bajada = $xpath->query("//*[@itemprop='description']")->item(0)->nodeValue;
        $cuerpo = $xpath->query("//*[@itemprop='articleBody']")->item(0)->nodeValue;

        return [
            'titulo' => $titulo,
            'bajada' => $bajada,
            'cuerpo' => $cuerpo
        ];
    }
}