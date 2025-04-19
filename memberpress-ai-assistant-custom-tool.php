<?php
/**
 * Plugin Name: MemberPress AI Assistant - Custom Tool Extension
 * Description: Example extension demonstrating how to add a custom tool via hooks
 * Version: 1.0.0
 * Author: MemberPress
 * Author URI: https://memberpress.com
 * Text Domain: memberpress-ai-assistant-custom-tool
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

class MPAI_Custom_Tool_Extension {
    
    /**
     * Initialize the extension
     */
    public function __construct() {
        // Register the custom tool when the tool registry is initialized
        add_action('MPAI_HOOK_ACTION_tool_registry_init', [$this, 'register_custom_tool']);

        // Filter available tools to add our custom tool
        add_filter('MPAI_HOOK_FILTER_available_tools', [$this, 'add_custom_tool_to_available_tools']);

        // Filter tool parameters before execution
        add_filter('MPAI_HOOK_FILTER_tool_parameters', [$this, 'modify_tool_parameters'], 10, 3);

        // Filter tool execution result
        add_filter('MPAI_HOOK_FILTER_tool_execution_result', [$this, 'modify_tool_result'], 10, 4);

        // Hook into tool execution events
        add_action('MPAI_HOOK_ACTION_before_tool_execution', [$this, 'log_before_tool_execution'], 10, 3);
        add_action('MPAI_HOOK_ACTION_after_tool_execution', [$this, 'log_after_tool_execution'], 10, 4);

        // Filter tool capability check
        add_filter('MPAI_HOOK_FILTER_tool_capability_check', [$this, 'check_tool_capability'], 10, 4);
    }
    
    /**
     * Register the custom tool with the tool registry
     */
    public function register_custom_tool() {
        // Check if the tool registry class exists
        if (!class_exists('MPAI_Tool_Registry')) {
            error_log('MPAI_Tool_Registry class not found');
            return;
        }
        
        // Get the tool registry instance
        global $mpai_tool_registry;
        if (!$mpai_tool_registry) {
            error_log('Tool registry instance not available');
            return;
        }
        
        // Include the custom tool class
        require_once plugin_dir_path(__FILE__) . 'class-mpai-custom-tool.php';
        
        // Register the tool definition
        $mpai_tool_registry->register_tool_definition(
            'custom_tool',
            'MPAI_Custom_Tool',
            plugin_dir_path(__FILE__) . 'class-mpai-custom-tool.php'
        );
        
        error_log('Custom tool registered with tool registry');
    }
    
    /**
     * Add the custom tool to the available tools list
     *
     * @param array $tools Available tools
     * @return array Modified tools list
     */
    public function add_custom_tool_to_available_tools($tools) {
        // Check if the custom tool is already in the list
        if (isset($tools['custom_tool'])) {
            return $tools;
        }
        
        // Create an instance of the custom tool
        if (class_exists('MPAI_Custom_Tool')) {
            $tools['custom_tool'] = new MPAI_Custom_Tool();
            error_log('Added custom tool to available tools');
        }
        
        return $tools;
    }
    
    /**
     * Modify tool parameters before execution
     *
     * @param array $parameters Tool parameters
     * @param string $tool_name Tool name
     * @return array Modified parameters
     */
    public function modify_tool_parameters($parameters, $tool_name, $tool) {
        // Only modify parameters for our custom tool
        if ($tool_name !== 'custom_tool') {
            return $parameters;
        }
        
        // Add a timestamp to the parameters
        $parameters['timestamp'] = current_time('mysql');
        error_log('Modified parameters for custom tool: ' . json_encode($parameters));
        
        return $parameters;
    }
    
    /**
     * Modify tool execution result
     *
     * @param mixed $result Tool execution result
     * @param string $tool_name Tool name
     * @param array $parameters Tool parameters
     * @return mixed Modified result
     */
    public function modify_tool_result($result, $tool_name, $parameters, $tool) {
        // Only modify results for our custom tool
        if ($tool_name !== 'custom_tool') {
            return $result;
        }
        
        // Add extension info to the result
        if (is_array($result)) {
            $result['extension_info'] = 'Modified by Custom Tool Extension';
            error_log('Modified result for custom tool: ' . json_encode($result));
        }
        
        return $result;
    }
    
    /**
     * Log before tool execution
     *
     * @param string $tool_name Tool name
     * @param array $parameters Tool parameters
     */
    public function log_before_tool_execution($tool_name, $parameters, $tool) {
        error_log('Before executing tool: ' . $tool_name . ' with parameters: ' . json_encode($parameters));
    }
    
    /**
     * Log after tool execution
     *
     * @param string $tool_name Tool name
     * @param array $parameters Tool parameters
     * @param mixed $result Tool result
     */
    public function log_after_tool_execution($tool_name, $parameters, $result, $tool) {
        error_log('After executing tool: ' . $tool_name . ' with result: ' . (is_array($result) ? json_encode($result) : $result));
    }
    
    /**
     * Check tool capability
     *
     * @param bool $has_capability Whether user has capability
     * @param string $tool_id Tool identifier
     * @param int $user_id User ID
     * @return bool Modified capability check result
     */
    public function check_tool_capability($has_capability, $tool_name, $parameters, $tool) {
        // Only modify capability check for our custom tool
        if ($tool_name !== 'custom_tool') {
            return $has_capability;
        }
        
        // Allow all users to use our custom tool
        return true;
    }
}

// Initialize the extension
new MPAI_Custom_Tool_Extension();