<?php

namespace Tapp\FilamentAuditing\Filament\Actions;

use Filament\Actions\Action;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Facades\Filament;
use Filament\Schemas\Components\Section;
use OwenIt\Auditing\Contracts\Audit;
use Tapp\FilamentAuditing\Concerns\CanRestoreAudit;
use Tapp\FilamentAuditing\Filament\Infolists\Components\AuditKeyValuesEntry;

class RestoreAuditAction extends Action
{
	use CanCustomizeProcess;
	use CanRestoreAudit;

	public static function getDefaultName(): ?string
	{
		return 'restoreAudit';
	}

	protected function setUp(): void
	{
		parent::setUp();

		$this
			->icon('heroicon-o-arrow-path')
			->modalWidth('xl')
			->modalAutofocus(false)
			->label(trans('filament-auditing::filament-auditing.action.restore'))
			->action(fn (Audit $record) => static::restoreAuditSelected($record))
			->schema([
						 Section::make(trans('filament-auditing::filament-auditing.action.restoring-from'))
							 ->schema([
										  AuditKeyValuesEntry::make('new_values')
											  ->hiddenLabel(),
									  ]),
						 Section::make(trans('filament-auditing::filament-auditing.action.restoring-to'))
							 ->schema([
										  AuditKeyValuesEntry::make('old_values')
											  ->hiddenLabel(),
									  ]),
					 ])
			->requiresConfirmation()
			->visible(
				fn (Audit $record): bool => Filament::auth()->user()->can(
						'restoreAudit',
						$record->auditable
					) && $record->event === 'updated'
			)
			->after(function ($livewire) {
				$livewire->dispatch('auditRestored');
			});
	}
}
