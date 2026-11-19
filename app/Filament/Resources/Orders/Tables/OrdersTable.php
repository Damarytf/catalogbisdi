<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('order_number')
                    ->label('Invoice')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable()
                    ->copyMessage('Nomor invoice disalin!'),

                TextColumn::make('customer_name')
                    ->label('Pemesan')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Order $record): string => $record->customer_contact),

                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable()
                    ->weight('semibold'),

                TextColumn::make('items_count')
                    ->counts('items')
                    ->label('Jumlah Item')
                    ->alignCenter(),

                SelectColumn::make('status')
                    ->label('Status Transaksi')
                    ->options([
                        'pending'   => '🟡 Baru / Menunggu Chat',
                        'in_chat'   => '🔵 Sedang Chat WA',
                        'completed' => '🟢 Selesai / Lunas',
                        'cancelled' => '🔴 Dibatalkan',
                    ])
                    ->selectablePlaceholder(false)
                    ->afterStateUpdated(function (Order $record, string $state): void {
                        if ($state === 'completed' && ! $record->completed_at) {
                            $record->update(['completed_at' => now()]);
                        }

                        Notification::make()
                            ->title('Status pesanan diperbarui')
                            ->success()
                            ->send();
                    }),

                TextColumn::make('created_at')
                    ->label('Waktu Checkout')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'pending'   => 'Baru / Menunggu Chat',
                        'in_chat'   => 'Sedang Chat WA',
                        'completed' => 'Selesai / Lunas',
                        'cancelled' => 'Dibatalkan',
                    ]),
            ])
            ->recordActions([
                Action::make('hubungi_wa')
                    ->label('Chat WA')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->color('success')
                    ->url(function (Order $record): ?string {
                        $contact = preg_replace('/[^0-9]/', '', $record->customer_contact);
                        if (! $contact) return null;
                        if (str_starts_with($contact, '0')) {
                            $contact = '62' . substr($contact, 1);
                        }
                        return "https://wa.me/{$contact}?text=" . urlencode("Halo {$record->customer_name}, kami dari Admin Toko Bisnis Digital terkait pesanan {$record->order_number}...");
                    }, shouldOpenInNewTab: true)
                    ->visible(fn (Order $record): bool => !empty($record->customer_contact) && preg_match('/[0-9]/', $record->customer_contact)),

                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

