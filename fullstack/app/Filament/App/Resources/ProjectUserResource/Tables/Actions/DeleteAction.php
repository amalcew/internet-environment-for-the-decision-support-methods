<?php

namespace App\Filament\App\Resources\ProjectUserResource\Tables\Actions;

use Closure;
use Illuminate\Database\Eloquent\Model;

class DeleteAction extends \Filament\Tables\Actions\DeleteAction
{
    /**
     * copied from parent
     * Changed to not delete owner
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('filament-actions::delete.single.label'));

        $this->modalHeading(fn(): string => __('filament-actions::delete.single.modal.heading', ['label' => $this->getRecordTitle()]));

        $this->modalSubmitActionLabel(__('filament-actions::delete.single.modal.actions.delete.label'));

        $this->successNotificationTitle(__('filament-actions::delete.single.notifications.deleted.title'));

        $this->color('danger');

        $this->icon('heroicon-m-trash');

        $this->requiresConfirmation();

        $this->modalIcon('heroicon-o-trash');

        $this->hidden(static function (Model $record): bool {
            if (!method_exists($record, 'trashed')) {
                return false;
            }

            return $record->trashed();
        });

        $this->action(function (): void {
            $result = $this->process(static function (Model $record) {
//                this is
                $owner = $record->project->user_id;
                if ($record->user_id != $owner) {
                    $record->delete();
                }
            });

            if (!$result) {
                $this->failure();

                return;
            }

            $this->success();
        });
    }
}
