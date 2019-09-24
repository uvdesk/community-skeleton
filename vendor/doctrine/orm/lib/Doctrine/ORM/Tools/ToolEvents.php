<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Doctrine\ORM\Tools;

class ToolEvents
{
    /**
     * The postGenerateSchemaTable event occurs in SchemaTool#getSchemaFromMetadata()
     * whenever an entity class is transformed into its table representation. It receives
     * the current non-complete Schema instance, the Entity Metadata Class instance and
     * the Schema Table instance of this entity.
     *
     * @var string
     */
    const postGenerateSchemaTable = 'postGenerateSchemaTable';

    /**
     * The postGenerateSchema event is triggered in SchemaTool#getSchemaFromMetadata()
     * after all entity classes have been transformed into the related Schema structure.
     * The EventArgs contain the EntityManager and the created Schema instance.
     *
     * @var string
     */
    const postGenerateSchema = 'postGenerateSchema';
}
