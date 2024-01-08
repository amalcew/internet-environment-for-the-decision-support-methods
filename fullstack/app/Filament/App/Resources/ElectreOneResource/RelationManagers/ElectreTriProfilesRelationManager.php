<?php

namespace App\Filament\App\Resources\ElectreOneResource\RelationManagers;

use App\Models\Criterion;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Value;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ElectreTriProfilesRelationManager extends RelationManager
{
    protected static string $relationship = 'electreTriProfile';

    public function table(Tables\Table $table): Tables\Table
    {
        self::deleteEmptyProfiles();
        $electreTri = $this->getOwnerRecord();
        $project = Project::all()->firstWhere('id', $electreTri->project_id);
        $datasetId = $project->dataset_id;
        $criteria = Criterion::where('dataset_id', $datasetId)->get();
        $tableColumns = $criteria->map(function ($criterion) {
            return Tables\Columns\TextColumn::make('criterion_' . $criterion->id)
                ->label($criterion->name)
                ->getStateUsing(function ($record, $column) use ($criterion) {
                    $valueEntry = Value::all()->where('profile_id', $record->id)
                        ->where('criterion_id', $criterion->id)
                        ->first();
//                    dd(Value::all()->where('criterion_id', $criterion->id));
                    return $valueEntry ? $valueEntry->value : 'Brak danych';
                })
                ->html();
        })->toArray();
        // Dodaj kolumny do definicji tabeli
        return $table
            ->columns(array_merge([
                Tables\Columns\TextColumn::make('name'),
                // inne kolumny...
            ], $tableColumns))
            ->headerActions([
                $this->getCreateAction()
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->emptyStateActions([
                $this->getCreateAction()
            ]);
    }

    public function form(Forms\Form $form): Forms\Form
    {
        $electreTri = $this->getOwnerRecord();
        $project = Project::all()->firstWhere('id', $electreTri->project_id);
        $datasetId = $project->dataset_id;
        $criteria = Criterion::where('dataset_id', $datasetId)->get();

        $formFields = $criteria->map(function ($criterion) {
            $colorClass = $criterion->type == 'cost' ? 'text-red-500' : 'text-green-500';

            return Forms\Components\TextInput::make('criterion_' . $criterion->id)
                ->label($criterion->name)
                ->extraAttributes(['class' => $colorClass]);
        })->toArray();

        return $form
            ->schema(array_merge([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                // inne pola formularza...
            ], $formFields));
    }

    private function getCreateAction() {
        return Tables\Actions\CreateAction::make()
            ->mutateFormDataUsing(function (array $data): array {
                $profile = new Profile;
                $profile->name = $data['name'];
                $electreTri = $this->getOwnerRecord();
                $project = Project::all()->firstWhere('id', $electreTri->project_id);
                $profile->electre_tri_id = $electreTri->id;
                $profile->dataset_id = $project->dataset_id;
                $profile->save();
                foreach ($data as $key => $value) {
                    if (str_starts_with($key, 'criterion_')) {
                        $criterionId = str_replace('criterion_', '', $key);
                        Value::create([
                            'profile_id' => $profile->id,
                            'criterion_id' => $criterionId,
                            'value' => $value
                        ]);
                    }
                }

                return [];
            });
    }

    private static function deleteEmptyProfiles() {
        Profile::whereNull('name')
            ->delete();
    }
}
