#!/usr/bin/env php
<?php

$GREEN = "\033[0;32m";

$BLUE = "\033[0;34m";

function info($message, $color = "\033[0m") {
    echo $color . $message . "\033[0m" . PHP_EOL;
}

echo PHP_EOL;

echo $BLUE . str_repeat("=", 30) . PHP_EOL;
echo $BLUE . "   INICIALIZAÇÃO COMPLETA   " . PHP_EOL;
echo $BLUE . str_repeat("=", 30) . PHP_EOL . PHP_EOL;

info("[OK] Arquivo .env criado", $GREEN);
info("[OK] Dependências instaladas", $GREEN);
info("[OK] Montando container...", $GREEN);
info("[OK] Container iniciado", $GREEN);
info("[OK] Tabelas criadas", $GREEN);

echo PHP_EOL;