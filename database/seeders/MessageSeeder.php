<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        // prendo gli appartamenti
        $apartments = Apartment::all();

        // genero 10 messaggi per appartamento
        foreach ($apartments as $apartment) {
            for ($i = 0; $i < rand(3, 7); $i++) {
                $message = new Message;
                $message->apartment_id = $apartment->id;
                $message->email = $faker->randomElement(['fabio@gmail.com', 'marco@gmail.com', 'simone@gmail.com', 'lorenzo@gmail.com', 'mattia@gmail.com']);
                $message->body = $faker->randomElement([
                    "Salve, vorrei avere qualche informazione in più in merito all'appartmento visto su BoolBnB",
                    "Buongiorno carissimo, è ancora diponibile l'appartmento per le date 12-17 Agosto ?",
                    "Ciao, è possibile sapere se ci sono delle disponibiltà in determinate date ? Attendo Vostre",
                    "Salve, sono in viaggio per lavoro e la location trovata sarebbe l'ideale. Vorrei qualche info in più",
                    "Buongiorno, posso avere qualche info in più sul tuo annuncio?",
                    "Hi, can i have some details about your advertisement? I will be there for summer",
                    "Ottima proposta, sono interessato. Contattami su questa mail al più presto",
                    "Ciao, mi piace molto.",
                    "Grazie per la Vostra ospitalità, soggiorno pazzesco.",
                    "Grazie per l'esperinza, la consiglierò ai nostri amici",
                    "Ospitalità TOP, voto 10!",
                    "Ne avevo sentito parlare, sono rimasto sbalordito",
                    "È richiesto presentare referenze o garanzie particolari per poter affittare l'appartamento?",
                    "Quali sono le modalità di pagamento accettate?",
                    "Quali sono le principali attrazioni turistiche e i ristoranti nelle vicinanze dell'alloggio?",
                    "Qual è la politica di cancellazione per questo alloggio?",
                    "Ci sono regole della casa particolari di cui dovrei essere a conoscenza?",
                    "Qual è la politica di pulizia dell'alloggio? È previsto un costo aggiuntivo per le pulizie?",
                    "Quali sono gli orari di check-in e check-out? È possibile organizzare un check-in tardivo?"
                ]);
                $message->sent = $faker->dateTimeBetween('-1month', 'now');
                $message->save();
            }
        }
    }
}