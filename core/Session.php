<?php

namespace app\core;

use app\models\PersistentSession;
use Exception;

class Session
{

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }


    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @throws Exception
     */
    public function setPersistentCustomerSession($customer_id): bool
    {
        $ps = new PersistentSession();
        $client_token = $ps->setCustomerSession(customer_id: $customer_id);
        // set cookie with expiration of 30 days
        setcookie('client_token', $client_token, time() + 2592000, '/');
        return true;
    }


    public function getPersistentCustomerSession(string $clientToken): bool|int
    {
        $ps = new PersistentSession();
        $customer_id = $ps->checkCustomerSession(clientToken: $clientToken);
        if ($customer_id) {
            return $customer_id;
        }
        return false;
    }


    public function deletePersistentCustomerSession(int $customer_id): void
    {
        $ps = new PersistentSession();
        $ps->deleteCustomerSession(customer_id: $customer_id);
        // delete cookie
        setcookie('client_token', '', time() - 3600, '/');
    }


    /**
     * @throws Exception
     */
    public function setPersistentEmployeeSession(int $employeeId, string $role): bool
    {
        $ps = new PersistentSession();
        $client_token = $ps->setEmployeeSession(employee_id: $employeeId, role: $role);
        // set cookie with expiration of 30 days
        setcookie('client_token', $client_token, time() + 2592000, '/');
        return true;
    }


    public function getPersistentEmployeeSession(string $clientToken): bool|array
    {
        $ps = new PersistentSession();
        $employee = $ps->checkEmployeeSession(clientToken: $clientToken);
        if ($employee) {
            return $employee;
        }
        return false;
    }


    public function deleteEmployeePersistentCookie(int $employee_id): void
    {
        $ps = new PersistentSession();
        $ps->deleteEmployeeSession(employee_id: $employee_id);
        // delete cookie
        setcookie('client_token', '', time() - 3600, '/');
    }

    public function get(string $key): mixed
    {
        return $_SESSION[$key] ?? "";
    }

    public function remove($key): void
    {
        unset($_SESSION[$key]);
    }

    public function destroy(): void
    {
        session_destroy();
    }

    public function setExpirationTime(int $seconds): void
    {
        $_SESSION['expiration_time'] = time() + $seconds;
    }


}