<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title_desc' => 'required|string|max:60|min:3',
            'n_rooms' => 'required|numeric|min:1|max:255',
            'n_bathrooms' => 'required|numeric|min:1|max:255',
            'n_beds' => 'required|numeric|min:1|max:255',
            'square_mts' => 'required|numeric|min:10|max:255',
            'img' => 'nullable|image',
            'visible' => 'boolean',
            'services' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title_desc.required' => "Inserire il nome dell'appartamento",
            'title_desc.max' => "Il nome dell'appartamento deve essere di massimo 60 caratteri",
            'title_desc.min' => "Il nome dell'appartamento deve essere di minimo 4 caratteri",
            'n_rooms.required' => "Inserire il numero delle stanze dell'appartamento",
            'n_rooms.numeric' => 'Il valore stanze deve essere numerico',
            'n_rooms.min' => 'Il valore numerico di stanze deve essere minimo di 1',
            'n_rooms.max' => 'Il valore numerico di stanze deve essere massimo di 255',
            'n_bathrooms.required' => "Inserire il numero dei bagni dell'appartamento",
            'n_bathrooms.numeric' => 'Il valore bagni deve essere numerico',
            'n_bathrooms.min' => 'Il valore numerico dei bagni deve essere minimo di 1',
            'n_bathrooms.max' => 'Il valore numerico dei bagni deve essere massimo di 255',
            'n_beds.required' => "Inserire il numero dei letti dell'appartamento",
            'n_beds.numeric' => 'Il valore letti deve essere numerico',
            'n_beds.min' => 'Il valore numerico dei letti deve essere minimo di 1',
            'n_beds.max' => 'Il valore numerico dei letti deve essere massimo di 255',
            'square_mts.required' => "Inserire il numero dei metri quadri dell'appartamento",
            'square_mts.numeric' => 'Il valore metri quadri deve essere numerico',
            'square_mts.min' => 'Il valore numerico dei metri quadri deve essere minimo di 10',
            'square_mts.max' => 'Il valore numerico dei metri quadri deve essere massimo di 255',
            'img.image' => 'Il file inserito deve essere di tipo immagine (jpg, jpeg, png, bmp, gif, svg, or webp)',
            'visible.boolean' => 'La checkbox può solo indicare se pubblicato o no',
            'services.required' => 'Spunta almeno un servizio offerto'
        ];
    }
}
