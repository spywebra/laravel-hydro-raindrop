<?php

declare(strict_types=1);

namespace Adrenth\LaravelHydroRaindrop\Console;

use Adrenth\LaravelHydroRaindrop\MfaHandler;
use Adrenth\LaravelHydroRaindrop\UserHelper;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Throwable;

/**
 * Class ResetHydro
 *
 * @package Adrenth\LaravelHydroRaindrop\Console
 */
class ResetHydro extends Command
{
    /**
     * {@inheritDoc}
     */
    protected $signature = 'hydro-raindrop:reset-hydro {user}';

    /**
     * {@inheritDoc}
     */
    protected $description = 'Reset Hydro Raindrop MFA for user.';

    /**
     * Handle the command.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            $userModelClass = resolve(config('hydro-raindrop.user_model_class'));

            /** @var Model $user */
            $user = $userModelClass->findOrFail($this->argument('user'));

            /** @var MfaHandler $mfaHandler */
            $mfaHandler = resolve(MfaHandler::class);

            $userHelper = $mfaHandler->getUserHelper($user);
            $userHelper->reset();
        } catch (Throwable $e) {
            $this->output->error('Could not reset Hydro Raindrop MFA for user: ' . $e->getMessage());
        }
    }
}
