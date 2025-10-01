<?php

namespace Tapp\FilamentAuditing\Filament\Resources\Audits\Schemas;

use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Fieldset;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Illuminate\Database\Eloquent\Builder;

class AuditFilters
{
	public static function configure(): array
	{
		return [
			Filter::make('created_at')
				->schema(
					[
						Fieldset::make(trans('filament-auditing::filament-auditing.filter.created_at'))
							->schema(
								[
									DatePicker::make('created_from')
										->label(
											trans('filament-auditing::filament-auditing.filter.created_from')
										)
										->columnSpanFull(),
									DatePicker::make('created_until')
										->label(
											trans('filament-auditing::filament-auditing.filter.created_until')
										)
										->columnSpanFull(),
								]
							),
					]
				)
				->query(function (Builder $query, array $data): Builder {
					return $query
						->when(
							$data['created_from'],
							fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
						)
						->when(
							$data['created_until'],
							fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
						);
				})
				->indicateUsing(function (array $data): array {
					$indicators = [];

					if ($data['created_from'] ?? null) {
						$indicators[] = Indicator::make(
							'Ettől ' . Carbon::parse($data['created_from'])->toFormattedDateString()
						)
							->removeField('created_from');
					}

					if ($data['created_until'] ?? null) {
						$indicators[] = Indicator::make(
							'Eddig ' . Carbon::parse($data['created_until'])->toFormattedDateString()
						)
							->removeField('created_until');
					}

					return $indicators;
				}),
		];
	}
}
