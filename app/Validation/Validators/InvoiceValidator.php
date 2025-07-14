<?php
namespace App\Validation\Validators;

/**
 * Son reglas de validación y mensajes de error utilizados en los formularios de App\Views\Invoice
 */
class InvoiceValidator {
    public function newRules() {
        return [
            'invoice_date' => [
                'rules' => 'required|valid_date[Y-m-d]',
                'errors' => [
                    'required' => 'La fecha de emisión es requerida',
                    'valid_date' => 'La fecha no es válida',
                ],
            ],
            'due_date' => [
                'rules' => 'required|valid_date[Y-m-d]',
                'errors' => [
                    'required' => 'La fecha de vencimiento es requerida',
                    'valid_date' => 'La fecha no es válida',
                ],
            ],
            'payment_status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El estado de la factura es requerido',
                ],
            ],
            'payment_method' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El método de pago es requerido',
                ],
            ],
        ];
    }
    // public function showRules() {
    //     return [
    //         'category_number' => [
    //             'rules' => 'permit_empty|integer',
    //             'errors' => [
    //                 'integer' => 'El número de ser entero',
    //             ],
    //         ],
    //         'amount' => [
    //             'rules' => 'permit_empty|decimal',
    //             'errors' => [
    //                 'decimal' => 'El número debe ser decimal',
    //             ],
    //         ],
    //     ];
    // }
}