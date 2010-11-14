<?php
/**
 * Copyright 2010 Jakob Westhoff. All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 
 *    1. Redistributions of source code must retain the above copyright notice,
 *       this list of conditions and the following disclaimer.
 * 
 *    2. Redistributions in binary form must reproduce the above copyright notice,
 *       this list of conditions and the following disclaimer in the documentation
 *       and/or other materials provided with the distribution.
 * 
 * THIS SOFTWARE IS PROVIDED BY JAKOB WESTHOFF ``AS IS'' AND ANY EXPRESS OR
 * IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO
 * EVENT SHALL JAKOB WESTHOFF OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
 * LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE
 * OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
 * ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 * The views and conclusions contained in the software and documentation are those
 * of the authors and should not be interpreted as representing official policies,
 * either expressed or implied, of Jakob Westhoff
**/

namespace org\westhoffswelt\revtrans\Writer\LastPassCsv;

/**
 * SecretsCsv\Entry storing all the needed information for one csv entry
 *
 * Furthermore this class takes care of proper formatting and escaping of the 
 * provided column data. 
 */
class Entry 
{
    /**
     * URL of this entry
     *
     * This is the first column 
     * 
     * @var string
     */
    protected $url;

    /**
     * Username of this entry
     *
     * This is the second column 
     * 
     * @var string
     */
    protected $username;

    /**
     * Password of this entry
     *
     * This is the third column 
     * 
     * @var string
     */
    protected $password;

    /**
     * Extra notes associated with this entry
     *
     * This is the fourth column 
     * 
     * @var string
     */
    protected $extra;

    /**
     * Name of this entry
     * 
     * This is the fifth column.
     *
     * @var string
     */
    protected $name;

    /**
     * Group of this entry
     * 
     * This is the fifth column.
     *
     * @var string
     */
    protected $group;

    /**
     * Construct a new entry
     *
     * Each of the columns may be specified as argument during construction. If 
     * null is specified the column is supposed to be empty. It may however be 
     * set later on using the appropriate setter methods. 
     * 
     * @param string $url
     * @param string $username
     * @param string $password
     * @param string $extra
     * @param string $name 
     * @param string $group
     */
    public function __construct( $url = null, $username = null, $password = null, $extra = null, $name = null, $group = null )
    {
        $this->url          = $url === null ? "" : $url;
        $this->username     = $username === null ? "" : $username;
        $this->password     = $password === null ? "" : $password;
        $this->extra        = $extra === null ? "" : $extra;
        $this->name         = $name === null ? "" : $name;
        $this->group        = $group === null ? "" : $group;
    }

    /**
     * Get the stored url 
     * 
     * @return string
     */
    public function getUrl() 
    {
        return $this->url;
    }

    /**
     * Set the url column for this entry
     *
     * Escaping of special characters will be done automatically. 
     * 
     * @param string $url 
     */
    public function setUrl( $url ) 
    {
        $this->url = $url;
    }

    /**
     * Get the stored username 
     * 
     * @return string
     */
    public function getUsername() 
    {
        return $this->username;
    }

    /**
     * Set the username column for this entry
     *
     * Escaping of special characters will be done automatically. 
     * 
     * @param string $username 
     */
    public function setUsername( $username ) 
    {
        $this->username = $username;
    }

    /**
     * Get the stored group 
     * 
     * @return string
     */
    public function getGroup() 
    {
        return $this->group;
    }

    /**
     * Set the group column for this entry
     *
     * Escaping of special characters will be done automatically. 
     * 
     * @param string $group 
     */
    public function setGroup( $group ) 
    {
        $this->group = $group;
    }

    /**
     * Get the stored password 
     * 
     * @return string
     */
    public function getPassword() 
    {
        return $this->password;
    }

    /**
     * Set the password column for this entry
     *
     * Escaping of special characters will be done automatically. 
     * 
     * @param string $password 
     */
    public function setPassword( $password ) 
    {
        $this->password = $password;
    }

    /**
     * Get the stored extra 
     * 
     * @return string
     */
    public function getExtra() 
    {
        return $this->extra;
    }

    /**
     * Set the extra column for this entry
     *
     * Escaping of special characters will be done automatically. 
     * 
     * @param string $extra 
     */
    public function setExtra( $extra ) 
    {
        $this->extra = $extra;
    }

    /**
     * Get the stored name 
     * 
     * @return string
     */
    public function getName() 
    {
        return $this->name;
    }

    /**
     * Set the name column for this entry
     *
     * Escaping of special characters will be done automatically. 
     * 
     * @param string $name 
     */
    public function setName( $name ) 
    {
        $this->name = $name;
    }

    /**
     * Append a new note to the extra field.
     *
     * The new note will automatically start on a newline, as well as end with 
     * a newline character. 
     * 
     * @param string $note 
     */
    public function addExtra( $extra ) 
    {
        if ( !substr( $this->extra, -1 ) === "\n" ) 
        {
            $this->extra .= "\n";
        }

        $this->extra .= $extra;

        $this->extra .= "\n";
    }

    /**
     * Convert the entry into a csv based string
     *
     * This is the default way of retrieving the entry for output. The 
     * conversion will take care of every needed escaping to conform to the csv 
     * files read by Secrets.
     *
     * The outputted string is guaranteed to end with a newline. 
     * 
     * @return string
     */
    public function __tostring() 
    {
        $csv = $this->escapeColumn( $this->url ) . ","
             . $this->escapeColumn( $this->username ) . ","
             . $this->escapeColumn( $this->password ) . ","
             . $this->escapeColumn( $this->extra ) . ","
             . $this->escapeColumn( $this->name ) . ","
             . $this->escapeColumn( $this->group ) . "\n";

        return $csv;
    }

    /**
     * Escape a given string to correct column format which can than be read by 
     * the Secrets CSV importer. 
     * 
     * @param string $column 
     * @return string
     */
    protected function escapeColumn( $column ) 
    {
        // If there is no column content it is not enclosed in quotes, because 
        // the parser does not handle this properly
        if ( strlen( $column ) === 0 ) 
        {
            return "";
        }
        else 
        {
            // The only escaping needed I am currently aware of is the 
            // encapsulation in double quotes, as well as to escape every in string 
            // double quote with two double quote characters following directly 
            // each other.

            return '"' . str_replace( '"', '""', $column ) . '"';
        }

    }
}

