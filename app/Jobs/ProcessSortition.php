<?php

namespace App\Jobs;

use App\Http\Repositories\SortitionRepository;
use App\Models\Sortition;
use App\Services\FunctionalitiesService;
use App\Services\QueueService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessSortition implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $payload;

    const situationActive = 1;
    const situationPending = 3;
    const delay = 30;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            if (!isset($this->payload['id']) || empty($this->payload['id'])) {
                throw new Exception("Erro no dados a serem processados do sorteio");
            }

            DB::beginTransaction();

            // Busca Sorteio
            $sortition = Sortition::find($this->payload['id']);
            if (!$sortition) {
                throw new Exception("Nenhum sorteio encontrado para o ID: " . $this->payload['id']);
            }

            if ($sortition->situation_id != self::situationPending) {
                throw new Exception("Situação da aposta inválida");
            }

            // Atualiza situação do sorteio com o resultado
            $sortition->drawn_number = FunctionalitiesService::drawnNumberGenerator();
            $sortition->situation_id = self::situationActive;
            $sortition->save();

            // Cria novo sorteio para disparar à fila
            $newSortition = SortitionRepository::insert([
                'situation_id' => self::situationPending
            ]);

            QueueService::dispatchSortition(['id' => $newSortition->id], self::delay);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
        }
    }
}
