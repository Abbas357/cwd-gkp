<?php

namespace App\Database;

use Illuminate\Database\Schema\Grammars\MySqlGrammar as BaseMySqlGrammar;

class CustomMySqlGrammar extends BaseMySqlGrammar
{
    protected function compileColumnListing()
    {
        return "column_name as `name`, 
                data_type as `type_name`, 
                column_type as `type`, 
                collation_name as `collation`, 
                is_nullable as `nullable`, 
                column_default as `default`, 
                column_comment as `comment`, 
                extra as `extra`";
    }
}
