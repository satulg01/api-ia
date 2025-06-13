<?php

namespace App\Http\Controllers;

use App\DTOs\GrokChatRequestDto;
use App\DTOs\GroqChatRequestDto;
use App\DTOs\OpenAIChatRequestDto;
use App\DTOs\HuggingFaceChatRequestDto;
use App\DTOs\ChatCompletionRequestDto;
use App\Http\Requests\GrokChatRequest;
use App\Http\Requests\GroqChatRequest;
use App\Http\Requests\OpenAIChatRequest;
use App\Http\Requests\HuggingFaceChatRequest;
use App\Http\Requests\ChatCompletionRequest;
use App\Services\GrokChatService;
use App\Services\GroqChatService;
use App\Services\OpenAIChatService;
use App\Services\HuggingFaceChatService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    public function __construct(
        private readonly GrokChatService $grokChatService,
        private readonly GroqChatService $groqChatService,
        private readonly OpenAIChatService $openAIChatService,
        private readonly HuggingFaceChatService $huggingFaceChatService
    ) {}

    public function chat(GrokChatRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['system_message'] = 'You are a helpful assistant.';
            $requestDto = GrokChatRequestDto::fromArray($data);
            
            $response = $this->grokChatService->chat($requestDto);
            
            return response()->json([
                'success' => true,
                'data' => $response->toArray()
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process chat request',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function groqChat(GroqChatRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['system_message'] = 'Responda com base no contexto abaixo: TechSolutions - Soluções Digitais
====================================

Nossa História
-------------
Em 2024, nasceu a TechSolutions, uma empresa dedicada a transformar a presença digital das empresas através de soluções tecnológicas inovadoras. Nossa missão é impulsionar o crescimento dos negócios no mundo digital, combinando criatividade e tecnologia para criar experiências digitais excepcionais.

Nossa Missão
-----------
Transformar ideias em soluções digitais inovadoras, ajudando empresas a estabelecer uma presença digital forte e eficiente no mercado atual. Acreditamos que a tecnologia deve ser acessível e benéfica para todos, e trabalhamos para democratizar o acesso às soluções digitais mais avançadas.

Nossa Visão
----------
Ser referência em soluções digitais, ajudando empresas a alcançarem seu máximo potencial no mundo digital através de tecnologia inovadora e criatividade. Buscamos constantemente expandir nossos horizontes, explorando novas aplicações tecnológicas e desenvolvendo soluções inovadoras.

Nossos Valores
-------------
• Inovação Constante: Estamos sempre à frente, explorando as mais recentes tecnologias
• Ética e Transparência: Todas as nossas soluções são desenvolvidas com princípios éticos rigorosos
• Excelência: Comprometimento com a qualidade em cada projeto
• Foco no Cliente: Entendemos que cada cliente é único e merece soluções personalizadas
• Trabalho em Equipe: Valorizamos a colaboração e o conhecimento compartilhado

Nossos Produtos e Soluções
-------------------------

1. Desenvolvimento Web
---------------------
Nossas soluções web são desenvolvidas com as mais modernas tecnologias e frameworks:

• Sites Institucionais
  - Design responsivo e moderno
  - Otimização para mecanismos de busca (SEO)
  - Integração com redes sociais
  - Painel administrativo personalizado
  - Análise de métricas e relatórios

• E-commerce
  - Plataformas completas de vendas online
  - Integração com gateways de pagamento
  - Sistema de gestão de estoque
  - Área do cliente personalizada
  - Relatórios de vendas e analytics

• Aplicações Web
  - Sistemas sob medida para sua empresa
  - Dashboards interativos
  - Integração com APIs
  - Automação de processos
  - Armazenamento em nuvem

2. Aplicativos Mobile
-------------------
Desenvolvemos aplicativos nativos e híbridos para iOS e Android:

• Apps Corporativos
  - Comunicação interna
  - Gestão de tarefas
  - Acesso remoto a sistemas
  - Relatórios em tempo real
  - Autenticação segura

• Apps para Clientes
  - Programas de fidelidade
  - Área do cliente mobile
  - Notificações push
  - Pagamentos mobile
  - Suporte integrado

• Apps Especializados
  - Soluções para saúde
  - Apps educacionais
  - Ferramentas de produtividade
  - Apps de entretenimento
  - Aplicativos de nicho

3. Soluções em Inteligência Artificial
------------------------------------
Implementamos IA em diversos aspectos do seu negócio:

• Chatbots e Atendimento
  - Assistente virtual 24/7
  - Atendimento automatizado
  - Resolução de dúvidas comuns
  - Integração com CRM
  - Análise de satisfação

• Análise Preditiva
  - Previsão de vendas
  - Análise de comportamento do cliente
  - Identificação de tendências
  - Otimização de estoque
  - Recomendações personalizadas

• Automação Inteligente
  - Processamento de documentos
  - Classificação automática
  - Extração de dados
  - Reconhecimento de padrões
  - Otimização de processos

Serviços Adicionais
-----------------

• Consultoria Digital
  - Análise de mercado
  - Estratégia digital
  - Transformação digital
  - Otimização de processos
  - Planejamento tecnológico

• Suporte e Manutenção
  - Monitoramento 24/7
  - Atualizações de segurança
  - Backup automático
  - Suporte técnico
  - Treinamento de equipe

• Integração de Sistemas
  - Conexão entre plataformas
  - Migração de dados
  - APIs personalizadas
  - Middleware
  - Cloud computing

Nossa Metodologia
---------------

1. Descoberta
• Análise de requisitos
• Pesquisa de mercado
• Definição de objetivos
• Planejamento estratégico

2. Design
• Prototipagem
• Design de interface
• Experiência do usuário
• Validação de conceito

3. Desenvolvimento
• Programação ágil
• Testes contínuos
• Integração de sistemas
• Documentação

4. Lançamento
• Testes finais
• Treinamento
• Implantação
• Suporte pós-lançamento

5. Manutenção
• Monitoramento
• Atualizações
• Otimizações
• Suporte contínuo

Nossa Equipe
-----------
Contamos com uma equipe de especialistas altamente qualificados em:
• Desenvolvimento Web
• Desenvolvimento Mobile
• Inteligência Artificial
• Design de Interface
• Experiência do Usuário
• Consultoria Digital
• Suporte Técnico

Por que escolher a TechSolutions?
-------------------------------

• Equipe especializada e certificada
• Metodologia ágil e transparente
• Tecnologias de ponta
• Suporte 24/7
• Resultados comprovados
• Preços competitivos
• Garantia de qualidade
• Atendimento personalizado

Impacto e Resultados
------------------
Ao longo dos anos, ajudamos centenas de empresas a:
• Reduzir custos operacionais em até 40%
• Aumentar a eficiência em processos críticos
• Melhorar a experiência do cliente
• Desenvolver novos produtos e serviços
• Transformar dados em insights acionáveis

Junte-se a Nós
------------
Se você está pronto para transformar sua presença digital e impulsionar seu negócio, estamos aqui para ajudar. Entre em contato conosco e descubra como podemos criar o futuro digital da sua empresa.

TechSolutions - Transformando sua Presença Digital
================================================';
            $requestDto = GroqChatRequestDto::fromArray($data);
            
            $response = $this->groqChatService->chat($requestDto);
            
            return response()->json([
                'success' => true,
                'data' => $response->toArray()
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process Groq chat request',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function openaiChat(OpenAIChatRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['system_message'] = 'You are a helpful assistant.';
            $requestDto = OpenAIChatRequestDto::fromArray($data);
            
            $response = $this->openAIChatService->chat($requestDto);
            
            return response()->json([
                'success' => true,
                'data' => $response->toArray()
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process OpenAI chat request',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function huggingFaceChat(HuggingFaceChatRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $requestDto = HuggingFaceChatRequestDto::fromArray($data);
            
            $response = $this->huggingFaceChatService->chat($requestDto);
            
            return response()->json([
                'success' => true,
                'data' => $response->toArray()
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process Hugging Face chat request',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function chatCompletion(ChatCompletionRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $requestDto = ChatCompletionRequestDto::fromArray($data);
            
            // Converter para o formato do HuggingFace e usar o serviço existente
            $huggingFaceData = [
                'question' => $requestDto->getFirstUserMessage(),
                'model' => $requestDto->model,
                'temperature' => $requestDto->temperature,
                'max_length' => $requestDto->maxTokens,
                'top_p' => $requestDto->topP,
                'top_k' => $requestDto->topK,
                'repetition_penalty' => $requestDto->repetitionPenalty,
                'max_time' => $requestDto->maxTime,
                'do_sample' => $requestDto->temperature !== null
            ];
            
            $huggingFaceDto = HuggingFaceChatRequestDto::fromArray($huggingFaceData);
            $response = $this->huggingFaceChatService->chat($huggingFaceDto);
            
            return response()->json([
                'success' => true,
                'data' => $response->toArray()
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process chat completion request',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
} 