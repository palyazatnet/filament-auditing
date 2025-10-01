<?php

namespace Tapp\FilamentAuditing\Filament\Resources\Audits\Schemas;

use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Tapp\FilamentAuditing\Filament\Infolists\Components\AuditKeyValuesEntry;
use Tapp\FilamentAuditing\Filament\Infolists\Components\AuditValuesEntry;

class AuditInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make(trans('filament-auditing::filament-auditing.infolist.tab.info'))
                            ->schema([
                                TextEntry::make('user.name')
                                    ->label(trans('filament-auditing::filament-auditing.infolist.user')),
                                TextEntry::make('created_at')
                                    ->dateTime(trans('filament-auditing::filament-auditing.infolist.date-format'))
                                    ->label(trans('filament-auditing::filament-auditing.infolist.created-at')),
                                TextEntry::make('auditable_type')
                                    ->label(trans('filament-auditing::filament-auditing.infolist.audited'))
                                    ->formatStateUsing(function (string $state) {
                                        return Str::afterLast($state, '\\');
                                    }),
                                TextEntry::make('event')
                                    ->label(trans('filament-auditing::filament-auditing.infolist.event')),
                                TextEntry::make('url')
                                    ->label(trans('filament-auditing::filament-auditing.infolist.url')),
                                TextEntry::make('ip_address')
                                    ->label(trans('filament-auditing::filament-auditing.infolist.ip-address')),
                                TextEntry::make('user_agent')
                                    ->label(trans('filament-auditing::filament-auditing.infolist.user-agent'))
                                    ->columnSpanFull(),
                                TextEntry::make('tags')
                                    ->label(trans('filament-auditing::filament-auditing.infolist.tags'))
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                        Tab::make(trans('filament-auditing::filament-auditing.infolist.tab.old-values'))
                            ->schema([
                                AuditKeyValuesEntry::make('old_values')
                                    ->hiddenLabel()
                            ]),
                        Tab::make(trans('filament-auditing::filament-auditing.infolist.tab.new-values'))
                            ->schema([
                                AuditKeyValuesEntry::make('new_values')
                                    ->hiddenLabel()
                            ]),
                    ]),
            ]);
    }
}
