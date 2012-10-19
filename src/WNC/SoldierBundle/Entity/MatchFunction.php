<?php

namespace WNC\SoldierBundle\Entity;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

class MatchFunction extends FunctionNode
{
    public $column = null;
    public $value = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER); // (2)
        $parser->match(Lexer::T_OPEN_PARENTHESIS); // (3)
        $this->column = $parser->ArithmeticPrimary(); // (4)
        $parser->match(Lexer::T_EQUALS); // (5)
        $this->value = $parser->ArithmeticPrimary(); // (6)
        $parser->match(Lexer::T_CLOSE_PARENTHESIS); // (3)
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'FLOOR(' .
            $this->column->dispatch($sqlWalker) . '= ' .
            $this->value->dispatch($sqlWalker) .
        ')'; // (7)
    }
}