<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
                                ->disabled()
                                ->dehydrated(false),
                            TextInput::make('customer_name')
                                ->label('Nama Pemesan')
                                ->required(),
                            TextInput::make('customer_contact')
                                ->label('Email / No. WhatsApp')
                                ->required(),
                            TextInput::make('total_amount')
                                ->label('Total Tagihan')
                                ->prefix('Rp')
                                ->numeric()
                                ->disabled()
                                ->dehydrated(false),
                            Textarea::make('notes')
                                ->label('Catatan dari Pemesan')
                                ->disabled()
                                ->columnSpanFull(),
                        ])->columns(2),

                    Section::make('Daftar Produk yang Dipesan')
                        ->schema([
                            Repeater::make('items')
                                ->relationship()
                                ->schema([
                                    TextInput::make('product_name')
                                        ->label('Nama Produk')
                                        ->disabled()
                                        ->columnSpan(2),
                                    TextInput::make('price')
                                        ->label('Harga')
                                        ->prefix('Rp')
                                        ->numeric()
                                        ->disabled(),
                                    TextInput::make('quantity')
                                        ->label('Qty')
                                        ->numeric()
                                        ->disabled(),
                                    TextInput::make('subtotal')
                                        ->label('Subtotal')
                                        ->prefix('Rp')
                                        ->numeric()
                                        ->disabled(),
                                ])
                                ->columns(5)
                                ->addable(false)
                                ->deletable(false)
                                ->reorderable(false)
                                ->columnSpanFull(),
                        ]),
                ])->columnSpan(['lg' => 2]),

                Group::make()->schema([
                    Section::make('Status Verifikasi Admin')
                        ->description('Update status setelah Anda memeriksa pesan WhatsApp atau bukti pembayaran')
                        ->schema([
                            Select::make('status')
                                ->label('Status Transaksi')
                                ->options([
                                    'pending'   => '🟡 Baru / Menunggu Chat WA',
                                    'in_chat'   => '🔵 Sedang Chat / Menunggu Transfer',
                                    'completed' => '🟢 Selesai / Terverifikasi Lunas',
                                    'cancelled' => '🔴 Dibatalkan / Tidak Ada Respon',
                                ])
                                ->required()
                                ->native(false)
                                ->live(),

                            DateTimePicker::make('completed_at')
                                ->label('Waktu Pembayaran Dikonfirmasi')
                                ->native(false),

                            Textarea::make('admin_notes')
                                ->label('Catatan Internal Admin')
                                ->placeholder('Contoh: Sudah transfer via BCA a.n Budi, link berkas digital sudah dikirim ke email.')
                                ->rows(4),
                        ]),
                ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }
}

