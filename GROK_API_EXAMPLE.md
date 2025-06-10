# Grok Chat API Endpoint

Este endpoint permite fazer perguntas para o modelo Grok-3 da X.AI.

## Endpoint
```
POST /api/chat
```

## Headers
```
Content-Type: application/json
Accept: application/json
```

## Parâmetros

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| question | string | Sim | A pergunta que você quer fazer ao Grok (máximo 4000 caracteres) |
| temperature | float | Não | Controla a criatividade da resposta de 0 a 2 (padrão: 0.7) |
| model | string | Não | Modelo a ser usado: "grok-3-latest" ou "grok-3-mini" (padrão: "grok-3-latest") |

## Exemplo de Requisição

### Pergunta Simples
```bash
curl -X POST http://localhost:8000/api/grok/chat \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "question": "Explique o que é inteligência artificial em termos simples"
  }'
```

### Pergunta com Configurações Personalizadas
```bash
curl -X POST http://localhost:8000/api/grok/chat \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "question": "Crie um poema sobre programação",
    "temperature": 1.2,
    "model": "grok-3-latest"
  }'
```

## Exemplo de Resposta

### Sucesso (200)
```json
{
  "success": true,
  "data": {
    "content": "Inteligência artificial (IA) é a capacidade de máquinas e computadores realizarem tarefas que normalmente requerem inteligência humana...",
    "model": "grok-3-latest",
    "usage": {
      "prompt_tokens": 25,
      "completion_tokens": 150,
      "total_tokens": 175
    }
  }
}
```

### Erro (500)
```json
{
  "success": false,
  "message": "Failed to process chat request",
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