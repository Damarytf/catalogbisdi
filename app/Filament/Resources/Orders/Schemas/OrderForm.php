<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Order;
use App\Models\Product;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()->schema([
                    Section::make('Informasi Pesanan & Pelanggan')
                        ->schema([
                            TextInput::make('order_number')
                                ->label('Nomor Invoice')
                                ->default(fn () => Order::generateOrderNumber())
                                ->disabled()
                                ->dehydrated(),

                            TextInput::make('customer_name')
                                ->label('Nama Pemesan')
                                ->placeholder('Contoh: Ahmad Fauzi')
                                ->required(),

                            TextInput::make('customer_contact')
                                ->label('No. WhatsApp / Email Pemesan')
                                ->placeholder('Contoh: 08123456789 atau nama@email.com')
                                ->required(),

                            TextInput::make('total_amount')
                                ->label('Total Tagihan (Otomatis)')
                                ->prefix('Rp')
                                ->numeric()
                                ->readOnly()
                                ->dehydrated()
                                ->helperText('Dihitung otomatis dari akumulasi produk di bawah'),

                            Textarea::make('notes')
                                ->label('Catatan Permintaan Khusus')
                                ->placeholder('Contoh: Minta dikirimkan format source code Figma atau revisi modul')
                                ->rows(2)
                                ->columnSpanFull(),
                        ])->columns(2),

                    Section::make('Daftar Produk yang Dipesan')
                        ->description('Pilih produk dari katalog atau ketik manual jika custom request')
                        ->schema([
                            Repeater::make('items')
                                ->relationship()
                                ->schema([
                                    Select::make('product_id')
                                        ->label('Pilih Dari Katalog')
                                        ->options(Product::pluck('name', 'id'))
                                        ->searchable()
                                        ->preload()
                                        ->live()
                                        ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                            if ($state && ($product = Product::find($state))) {
                                                $price = (float) ($product->sale_price ?? $product->price);
                                                $qty = (int) ($get('quantity') ?: 1);
                                                $set('product_name', $product->name);
                                                $set('price', $price);
                                                $set('quantity', $qty);
                                                $set('subtotal', $price * $qty);
                                            }
                                        })
                                        ->columnSpan(2),

                                    TextInput::make('product_name')
                                        ->label('Nama Produk')
                                        ->required()
                                        ->columnSpan(2),

                                    TextInput::make('price')
                                        ->label('Harga Satuan')
                                        ->prefix('Rp')
                                        ->numeric()
                                        ->required()
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(function (Get $get, Set $set) {
                                            $price = (float) ($get('price') ?? 0);
                                            $qty = (int) ($get('quantity') ?? 1);
                                            $set('subtotal', $price * $qty);
                                        })
                                        ->columnSpan(1),

                                    TextInput::make('quantity')
                                        ->label('Qty')
                                        ->numeric()
                                        ->default(1)
                                        ->minValue(1)
                                        ->required()
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(function (Get $get, Set $set) {
                                            $price = (float) ($get('price') ?? 0);
                                            $qty = (int) ($get('quantity') ?? 1);
                                            $set('subtotal', $price * $qty);
                                        })
                                        ->columnSpan(1),

                                    TextInput::make('subtotal')
                                        ->label('Subtotal')
                                        ->prefix('Rp')
                                        ->numeric()
                                        ->readOnly()
                                        ->dehydrated()
                                        ->columnSpan(1),
                                ])
                                ->columns(7)
                                ->defaultItems(1)
                                ->addActionLabel('+ Tambah Produk ke Pesanan')
                                ->live()
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    $items = $get('items') ?? [];
                                    $total = 0;
                                    foreach ($items as $item) {
                                        $total += (float) ($item['subtotal'] ?? 0);
                                    }
                                    $set('total_amount', $total);
                                })
                                ->columnSpanFull(),
                        ]),
                ])->columnSpan(['lg' => 2]),

                Group::make()->schema([
                    Section::make('Status Verifikasi & Pembayaran')
                        ->description('Kelola status pesanan dari chat WhatsApp')
                        ->schema([
                            Select::make('status')
                                ->label('Status Transaksi')
                                ->options([
                                    'pending'   => '🟡 Baru / Menunggu Chat WA',
                                    'in_chat'   => '🔵 Sedang Chat / Menunggu Transfer',
                                    'completed' => '🟢 Selesai / Terverifikasi Lunas',
                                    'cancelled' => '🔴 Dibatalkan / Tidak Ada Respon',
                                ])
                                ->default('in_chat')
                                ->required()
                                ->native(false)
                                ->live(),

                            DateTimePicker::make('completed_at')
                                ->label('Waktu Pembayaran Dikonfirmasi')
                                ->native(false)
                                ->helperText('Diisi otomatis jika status diubah ke Selesai'),

                            Textarea::make('admin_notes')
                                ->label('Catatan Internal Admin')
                                ->placeholder('Contoh: Customer memesan via WhatsApp. Sudah transfer via BCA, berkas digital sudah dikirim.')
                                ->rows(4),
                        ]),
                ])->columnSpan(['lg' => 1]),
            ])
            ->columns(['lg' => 3]);
    }
}
