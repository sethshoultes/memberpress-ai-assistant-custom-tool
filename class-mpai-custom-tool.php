<?php
/**
 * Custom Tool Implementation
 *
 * @package MemberPress AI Assistant - Custom Tool Extension
 */

// Prevent direct access.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Custom Tool Implementation
 */
class MPAI_Custom_Tool extends MPAI_Base_Tool {
    /**
     * Constructor
     */
    public function __construct() {
        $this->name = 'custom_tool';
        $this->description = 'A custom tool that demonstrates the hook system';
    }
    
    /**
     * Get parameters schema
     *
     * @return array Parameters schema
     */
    protected function get_parameters() {
        return [
            'text' => [
                'type' => 'string',
                'description' => 'Text to process'
            ],
            'operation' => [
                'type' => 'string',
                'description' => 'Operation to perform (uppercase, lowercase, reverse)',
                'enum' => ['uppercase', 'lowercase', 'reverse']
            ]
        ];
    }
    
    /**
     * Get required parameters
     *
     * @return array List of required parameter names
     */
    protected function get_required_parameters() {
        return ['text', 'operation'];
    }
    
    /**
     * Execute the tool implementation with validated parameters
     *
     * @param array $parameters Validated parameters for the tool
     * @return mixed Tool result
     */
    protected function execute_tool($parameters) {
        $text = $parameters['text'];
        $operation = $parameters['operation'];
        $result = '';
        
        switch ($operation) {
            case 'uppercase':
                $result = strtoupper($text);
                break;
                
            case 'lowercase':
                $result = strtolower($text);
                break;
                
            case 'reverse':
                $result = strrev($text);
                break;
                
            default:
                throw new Exception('Invalid operation: ' . $operation);
        }
        
        // Log the operation
        if (function_exists('mpai_log_info')) {
            mpai_log_info('Custom tool executed with operation: ' . $operation, 'custom-tool');
        }
        
        return [
            'success' => true,
            'tool' => 'custom_tool',
            'operation' => $operation,
            'original_text' => $text,
            'result' => $result,
            'timestamp' => isset($parameters['timestamp']) ? $parameters['timestamp'] : current_time('mysql')
        ];
    }
}