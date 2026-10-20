public function destroyPergunta(Pergunta $pergunta)
{
    // ADICIONE ESTA LINHA EXATAMENTE AQUI:
    $this->authorize('delete', $pergunta);

    // O restante do seu código que já estava aí continua igual:
    $pergunta->delete();
    return redirect()->back()->with('success', 'Pergunta excluída!');
}
