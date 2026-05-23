<?php

use Illuminate\Support\Facades\DB;

class CatalogCreationService {

    public function create(array $data) {
        try {
            return DB::transaction(function () use($data) {

            });

        } catch(\Exception $e) {

        }
    }
}