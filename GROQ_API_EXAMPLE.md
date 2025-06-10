# Groq Chat API Endpoint

Este endpoint permite fazer perguntas para os modelos ultrarrápidos do Groq.

## Endpoint
```
POST /api/groq-chat
```

## Headers
```
Content-Type: application/json
Accept: application/json
```

## Parâmetros

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| question | string | Sim | A pergunta que você quer fazer ao modelo (máximo 4000 caracteres) |
| temperature | float | Não | Controla a criatividade da resposta de 0 a 2 (padrão: 0.7) |
| model | string | Não | Modelo a ser usado (padrão: "llama-3.3-70b-versatile") |
| max_tokens | integer | Não | Máximo de tokens na resposta (1 a 8192) |

## Modelos Disponíveis

- `llama-3.3-70b-versatile` (padrão) - Modelo mais completo e versátil
- `llama-3.1-8b-instant` - Modelo mais rápido para respostas simples
- `llama-3.1-70b-versatile` - Modelo balanceado
- `gemma2-9b-it` - Modelo do Google para tarefas de instrução
- `mixtral-8x7b-32768` - Modelo Mixtral com contexto estendido

## Exemplo de Requisição

### Pergunta Simples
```bash
curl -X POST http://localhost:8000/api/groq-chat \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "question": "Explique o que é inteligência artificial em termos simples"
  }'
```

### Pergunta com Configurações Personalizadas
```bash
curl -X POST http://localhost:8000/api/groq-chat \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "question": "Crie um poema sobre programação",
    "temperature": 1.2,
    "model": "llama-3.3-70b-versatile",
    "max_tokens": 200
  }'
```

### Teste no arquivo requests.http
```http
# Groq Chat
POST http://localhost:8000/api/groq-chat
Content-Type: application/json

{
    "question": "Qual a capital do Brasil?",
    "model": "llama-3.3-70b-versatile",
    "temperature": 0.7,
    "max_tokens": 100
}
```

## Exemplo de Resposta

### Sucesso (200)
```json
{
  "success": true,
  "data": {
    "content": "A capital do Brasil é Brasília, localizada no Distrito Federal. A cidade foi inaugurada em 1960 e foi planejada especificamente para ser a capital federal do país.",
    "model": "llama-3.3-70b-versatile",
    "finish_reason": "stop",
    "usage": {
      "prompt_tokens": 25,
      "completion_tokens": 35,
      "total_tokens": 60
    }
  }
}
```

### Erro (500)
```json
{
  "success": false,
  "message": "Failed to process Groq chat request",
  "error": "Detalhes do erro..."
}
```

### Erro de Validação (422)
```json
{
  "message": "The question field is required.",
  "errors": {
    "question": ["A pergunta é obrigatória."]
  }
}
```