<?php

namespace Ecs\L8Core\Traits;

use DB;

trait Transaction
{
    protected function beginTransaction()
    {
        DB::beginTransaction();
    }

    protected function commit()
    {
        DB::commit();
    }

    protected function rollback()
    {
        DB::rollback();
    }
}
