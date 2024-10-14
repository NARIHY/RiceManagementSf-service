<?php
namespace Sucre\Money;

/**
 * Class MoneyManager
 *
 * This class manages the financial transactions of a wholesaler.
 * It allows adding, subtracting amounts, and keeps track of transaction history.
 *
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright RANDRIANARISOA 2024
 */
class MoneyManager {
    private float $amount;
    private array $transactionHistory = [];

    /**
     * MoneyManager constructor.
     *
     * Initializes the money manager with an initial amount.
     *
     * @param float $initialAmount The initial amount of money.
     */
    public function __construct(float $initialAmount) {
        $this->amount = $initialAmount;
        $this->transactionHistory[] = [
            'type' => 'initial',
            'amount' => $initialAmount,
            'balance' => $initialAmount,
            'date' => new \DateTime(),
        ];
    }

    /**
     * Adds a specified amount to the current amount.
     *
     * @param float $amount The amount to add.
     */
    public function add(float $amount): void {
        $this->amount += $amount;
        $this->logTransaction('add', $amount);
    }

    /**
     * Subtracts a specified amount from the current amount.
     *
     * @param float $amount The amount to subtract.
     * @throws \InvalidArgumentException If the amount to subtract exceeds the available balance.
     */
    public function subtract(float $amount): void {
        if ($amount > $this->amount) {
            throw new \InvalidArgumentException("Amount to subtract exceeds available balance.");
        }
        $this->amount -= $amount;
        $this->logTransaction('subtract', $amount);
    }

    /**
     * Returns the total available amount.
     *
     * @return float The current total amount.
     */
    public function getTotal(): float {
        return $this->amount;
    }

    /**
     * Returns the transaction history.
     *
     * @return array An array of transaction records.
     */
    public function getTransactionHistory(): array {
        return $this->transactionHistory;
    }

    /**
     * Processes a sale by subtracting the sale amount from the current balance.
     *
     * @param float $amount The amount of the sale.
     */
    public function sell(float $amount): void {
        $this->subtract($amount); // This will log as 'subtract'
        // Instead of logging 'subtract' here, we log 'sale' before calling subtract.
        $this->logTransaction('sale', $amount); // Log the sale before subtracting
    }

    /**
     * Records an expense by subtracting the expense amount from the current balance.
     *
     * @param float $amount The amount of the expense.
     */
    public function expense(float $amount): void {
        $this->subtract($amount);
        $this->logTransaction('expense', $amount);
    }

    /**
     * Logs a transaction into the transaction history.
     *
     * @param string $type The type of transaction (add, subtract, sale, expense).
     * @param float $amount The amount involved in the transaction.
     */
    private function logTransaction(string $type, float $amount): void {
        $this->transactionHistory[] = [
            'type' => $type,
            'amount' => $amount,
            'balance' => $this->amount,
            'date' => new \DateTime(),
        ];
    }
}
