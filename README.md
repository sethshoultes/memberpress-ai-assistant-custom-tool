# MemberPress AI Assistant - Custom Tool Extension

## Description
This WordPress plugin provides an example extension demonstrating how to add a custom tool to the MemberPress AI Assistant plugin via hooks. It serves as a reference implementation for developers who want to extend the MemberPress AI Assistant with additional tools.

## Features
- Registers a custom text processing tool with MemberPress AI Assistant
- Demonstrates how to use hooks and filters to integrate with the AI Assistant
- Showcases parameters validation and tool execution
- Provides examples of logging and capability checking

## Installation
1. Upload the `memberpress-ai-assistant-custom-tool` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Make sure MemberPress AI Assistant is installed and activated

## Usage
The plugin registers a custom tool that can perform text operations:
- Uppercase conversion
- Lowercase conversion
- Text reversal

## Hooks and Filters
This extension demonstrates the following hooks:
- `MPAI_HOOK_ACTION_tool_registry_init` - Register custom tools
- `MPAI_HOOK_FILTER_available_tools` - Add tools to the available tools list
- `MPAI_HOOK_FILTER_tool_parameters` - Modify parameters before execution
- `MPAI_HOOK_FILTER_tool_execution_result` - Modify results after execution
- `MPAI_HOOK_ACTION_before_tool_execution` - Hook before tool execution
- `MPAI_HOOK_ACTION_after_tool_execution` - Hook after tool execution
- `MPAI_HOOK_FILTER_tool_capability_check` - Custom capability checks

## Requirements
- WordPress 5.8 or higher
- MemberPress AI Assistant plugin

## License
GPL v2 or later

## Author
MemberPress - https://memberpress.com