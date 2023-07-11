<?php

namespace Modules\Payment\Repository;

if (!interface_exists('NoteRepository')) {
    interface NoteRepository
    {
        /**
         * Get all payment
         *
         * @return null|object
         */
        public function all(): ?object;


         /**
         * Get bill where id
         *
         * @param string $id
         * @return object
         */
        public function whereId(string $id): object;

        public function getByBillId($billId);

        /**
         * Save spending
         *
         * @param array $request
         * @return boolean
         */
        public function save(array $request): bool;

        /**
         * Remove room
         *
         * @return boolean
         */
        public function delete(string $id): bool;
    }
}
